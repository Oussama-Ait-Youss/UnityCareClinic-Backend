document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('patientModal');
    const form = document.getElementById('patientForm');

    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            clearErrors();

            document.getElementById('patientId').value = this.getAttribute('data-id');
            document.getElementById('patientFirstName').value = this.getAttribute('data-firstname');
            document.getElementById('patientLastName').value = this.getAttribute('data-lastname');
            document.getElementById('patientEmail').value = this.getAttribute('data-email');
            document.getElementById('patientPhone').value = this.getAttribute('data-phone');
            
            const genderSelect = document.getElementById('patientGender');
            if(genderSelect) genderSelect.value = this.getAttribute('data-gender');

            modal.classList.remove('hidden');
        });
    });

    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        const toggleError = (id, show) => {
            const el = document.getElementById(id);
            if(show) {
                el.classList.remove('hidden');
                isValid = false;
            } else {
                el.classList.add('hidden');
            }
        };

        const fname = document.getElementById('patientFirstName').value.trim();
        toggleError('error-firstname', fname === '');

        const lname = document.getElementById('patientLastName').value.trim();
        toggleError('error-lastname', lname === '');

        const email = document.getElementById('patientEmail').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        toggleError('error-email', !emailRegex.test(email));

        const phone = document.getElementById('patientPhone').value.trim();
        toggleError('error-phone', phone.length < 8);

        const gender = document.getElementById('patientGender').value;
        toggleError('error-gender', gender === '');

        if (!isValid) {
            e.preventDefault();
        }
    });
});

function closeModal() {
    document.getElementById('patientModal').classList.add('hidden');
    clearErrors();
}

function clearErrors() {
    const errors = document.querySelectorAll('[id^="error-"]');
    errors.forEach(el => el.classList.add('hidden'));
}
