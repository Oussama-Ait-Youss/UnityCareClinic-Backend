    // ==========================================
    // 1. PATIENT MODAL LOGIC
    // ==========================================
    const patientModal = document.getElementById('patientModal');
    const patientForm = document.getElementById('patientForm');

    // Function: Open "Add Patient" Modal
    function openAddPatientModal() {
        if(patientForm) patientForm.reset();
        document.getElementById('patientId').value = ''; 
        document.getElementById('modalTitle').innerText = 'Add New Patient';
        // Clear errors if function exists
        if (typeof clearErrors === 'function') clearErrors();
        patientModal.classList.remove('hidden');
    }

    // Function: Open "Modify Patient" Modal (Event Delegation)
    document.addEventListener('DOMContentLoaded', function() {
        // We use a specific class 'edit-patient-btn' to avoid confusion with doctors
        const patientButtons = document.querySelectorAll('.edit-patient-btn'); 

        patientButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Get Data
                document.getElementById('patientId').value = this.getAttribute('data-id');
                document.getElementById('patientFirstName').value = this.getAttribute('data-firstname');
                document.getElementById('patientLastName').value = this.getAttribute('data-lastname');
                document.getElementById('patientEmail').value = this.getAttribute('data-email');
                document.getElementById('patientPhone').value = this.getAttribute('data-phone');

                const genderSelect = document.getElementById('patientGender');
                if(genderSelect) genderSelect.value = this.getAttribute('data-gender');

                document.getElementById('modalTitle').innerText = 'Modify Patient';
                patientModal.classList.remove('hidden');
            });
        });
    });

    // ==========================================
    // 2. DOCTOR MODAL LOGIC
    // ==========================================
    const doctorModal = document.getElementById('doctorModal');
    const doctorForm = document.getElementById('doctorForm');

    // Function: Open "Add Doctor" Modal
    function openAddDoctorModal(e) {
        if(e) e.preventDefault();
        if(doctorForm) doctorForm.reset();
        document.getElementById('doctorId').value = ''; 
        // We use a specific ID for doctor title to not overwrite patient title if they share ID
        const docTitle = document.getElementById('doctorModalTitle') || document.getElementById('modalTitle');
        if(docTitle) docTitle.innerText = 'Add New Doctor';
        
        doctorModal.classList.remove('hidden');
    }

    // Function: Open "Modify Doctor" Modal
    document.addEventListener('DOMContentLoaded', (e) => {
        e.preventDefault();
        // We use a specific class 'edit-doctor-btn'
        const doctorButtons = document.querySelectorAll('.edit-doctor-btn');

        doctorButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Get Data
                document.getElementById('doctorId').value = this.getAttribute('data-id');
                document.getElementById('docFirstName').value = this.getAttribute('data-firstname');
                document.getElementById('docLastName').value = this.getAttribute('data-lastname');
                document.getElementById('docEmail').value = this.getAttribute('data-email');
                document.getElementById('docPhone').value = this.getAttribute('data-phone');
                document.getElementById('docSpecialty').value = this.getAttribute('data-specialty');
                
                // Select Department
                const deptSelect = document.getElementById('docDepartment');
                if(deptSelect) deptSelect.value = this.getAttribute('data-dept-id');

                const docTitle = document.getElementById('doctorModalTitle') || document.getElementById('modalTitle');
                if(docTitle) docTitle.innerText = 'Modify Doctor';
                
                doctorModal.classList.remove('hidden');
            });
        });
    });

    // ==========================================
    // 3. SHARED / HELPER FUNCTIONS
    // ==========================================
    
    // Function to close ANY modal (attached to Cancel buttons)
    function closeModalpatient() {
        if(patientModal) patientModal.classList.add('hidden');
    }
    function closeModaldoctor() {
        if(doctorModal) doctorModal.classList.add('hidden');
    }

