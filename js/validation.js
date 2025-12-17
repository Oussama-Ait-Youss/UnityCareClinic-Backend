document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('patientModal');
    const form = document.getElementById('patientForm');

    // --- 1. OPEN MODAL LOGIC ---
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Clear previous error messages when opening
            clearErrors();

            // Fill Form Data
            document.getElementById('patientId').value = this.getAttribute('data-id');
            document.getElementById('patientFirstName').value = this.getAttribute('data-firstname');
            document.getElementById('patientLastName').value = this.getAttribute('data-lastname');
            document.getElementById('patientEmail').value = this.getAttribute('data-email');
            document.getElementById('patientPhone').value = this.getAttribute('data-phone');
            
            const genderSelect = document.getElementById('patientGender');
            if(genderSelect) genderSelect.value = this.getAttribute('data-gender');

            // Show Modal
            modal.classList.remove('hidden');
        });
    });

    // --- 2. VALIDATION LOGIC ---
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Helper function to show/hide error text
        const toggleError = (id, show) => {
            const el = document.getElementById(id);
            if(show) {
                el.classList.remove('hidden');
                isValid = false;
            } else {
                el.classList.add('hidden');
            }
        };

        // Validate First Name (Cannot be empty)
        const fname = document.getElementById('patientFirstName').value.trim();
        toggleError('error-firstname', fname === '');

        // Validate Last Name (Cannot be empty)
        const lname = document.getElementById('patientLastName').value.trim();
        toggleError('error-lastname', lname === '');

        // Validate Email (Regex for format)
        const email = document.getElementById('patientEmail').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        toggleError('error-email', !emailRegex.test(email));

        // Validate Phone (Must be at least 8 digits)
        const phone = document.getElementById('patientPhone').value.trim();
        toggleError('error-phone', phone.length < 8);

        // Validate Gender (Must be selected)
        const gender = document.getElementById('patientGender').value;
        toggleError('error-gender', gender === '');

        // IF INVALID: Stop the form from submitting
        if (!isValid) {
            e.preventDefault();
        }
    });
});

// Helper: Close Modal
function closeModal() {
    document.getElementById('patientModal').classList.add('hidden');
    clearErrors();
}

// Helper: Clear all error messages
function clearErrors() {
    const errors = document.querySelectorAll('[id^="error-"]');
    errors.forEach(el => el.classList.add('hidden'));
}
