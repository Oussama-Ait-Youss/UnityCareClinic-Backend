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
    // 1. Close Modal Helper
    function closeDoctorModal() {
        document.getElementById('doctorModal').classList.add('hidden');
    }

    // 2. Open "Add New" Modal (Resets form)
    function openAddDoctorModal() {
        document.getElementById('doctorForm').reset();
        document.getElementById('doctorId').value = ''; // Clear ID for new entry
        document.getElementById('doctorModalTitle').innerText = 'Add New Doctor';
        document.getElementById('doctorModal').classList.remove('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // 3. Listen for clicks on "Modify" buttons
        const editButtons = document.querySelectorAll('.edit-doctor-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Get Data
                const id = this.getAttribute('data-id');
                const fname = this.getAttribute('data-firstname');
                const lname = this.getAttribute('data-lastname');
                const email = this.getAttribute('data-email');
                const phone = this.getAttribute('data-phone');
                const specialty = this.getAttribute('data-specialty');
                const deptId = this.getAttribute('data-dept-id');

                // Fill Inputs
                document.getElementById('doctorId').value = id;
                document.getElementById('docFirstName').value = fname;
                document.getElementById('docLastName').value = lname;
                document.getElementById('docEmail').value = email;
                document.getElementById('docPhone').value = phone;
                document.getElementById('docSpecialty').value = specialty;
                
                // Select the correct Department in the dropdown
                const deptSelect = document.getElementById('docDepartment');
                if(deptSelect) deptSelect.value = deptId;

                // Show Modal
                document.getElementById('doctorModalTitle').innerText = 'Modify Doctor';
                document.getElementById('doctorModal').classList.remove('hidden');
            });
        });
    });
