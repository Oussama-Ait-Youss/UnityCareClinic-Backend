document.addEventListener('DOMContentLoaded', function() {
    // 1. Find all buttons with class 'edit-btn'
    const editButtons = document.querySelectorAll('.edit-btn');

    // 2. Loop through them and attach the event listener
    editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // STOP the link from navigating to a new page
            e.preventDefault(); 

            // 3. Get the data from the clicked link (using 'this')
            const id = this.getAttribute('data-id');
            const firstName = this.getAttribute('data-firstname');
            const lastName = this.getAttribute('data-lastname');
            const email = this.getAttribute('data-email');
            const gender = this.getAttribute('data-gender');
            const phone = this.getAttribute('data-phone');

            // 4. Fill the Modal Inputs
            // (Ensure your Modal inputs have these exact IDs)
            document.getElementById('patientId').value = id;
            document.getElementById('patientFirstName').value = firstName;
            document.getElementById('patientLastName').value = lastName;
            document.getElementById('patientEmail').value = email;
            document.getElementById('patientPhone').value = phone;

            // Handle Gender Select Box
            const genderSelect = document.getElementById('patientGender');
            if(genderSelect) {
                genderSelect.value = gender;
            }

            // 5. Update Title & Show Modal
            // (Assumes your modal main div has id="patientModal")
            const modalTitle = document.getElementById('modalTitle');
            if(modalTitle) modalTitle.innerText = 'Modify Patient';
            
            document.getElementById('patientModal').classList.remove('hidden');
        });
    });
});
function openAddPatientModal() {
    // 1. Reset the entire form (clears text boxes)
    document.getElementById('patientForm').reset();
    
    // 2. CRITICAL: Clear the ID field. 
    // If ID is empty, save_patient.php knows to create a NEW record.
    document.getElementById('patientId').value = '';
    
    // 3. Set the Modal Title
    document.getElementById('modalTitle').innerText = 'Add New Patient';
    
    // 4. Clear any validation error messages from previous times
    // (This calls the helper function we made in the previous step)
    if (typeof clearErrors === 'function') { 
        clearErrors(); 
    }
    
    // 5. Show the Modal
    document.getElementById('patientModal').classList.remove('hidden');
}