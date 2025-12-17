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


   function openAddDeptModal(e) {
        if(e) e.preventDefault(); // Stop page reload

        const modal = document.getElementById('deptModal');
        const form = document.getElementById('deptForm');

        if (!modal || !form) {
            console.error("Error: Modal or Form not found. Check IDs 'deptModal' and 'deptForm'");
            return;
        }

        // Reset and Prepare Form
        form.reset();
        document.getElementById('deptId').value = ''; // Empty ID = Create New
        const title = document.getElementById('modalTitle');
        if(title) title.innerText = 'Add New Department';
        
        // Show Modal
        modal.classList.remove('hidden');
    }

function openAddDeptModal(e) {
        if(e) e.preventDefault(); // Stop page reload

        const modal = document.getElementById('deptModal');
        const form = document.getElementById('deptForm');

        if (!modal || !form) {
            console.error("Error: Modal or Form not found.");
            return;
        }

        // Reset Form & Clear ID
        form.reset();
        document.getElementById('deptId').value = ''; 
        
        // Update Title
        const title = document.getElementById('modalTitle');
        if(title) title.innerText = 'Add New Department';
        
        // Show Modal
        modal.classList.remove('hidden');
    }

    // ==========================================
    // 1. SETUP VARIABLES
    // ==========================================
    const deptModal = document.getElementById('deptModal');
    const deptForm = document.getElementById('deptForm');

    // ==========================================
    // 2. OPEN "ADD DEPARTMENT" MODAL
    // ==========================================
    function openAddDeptModal(e) {
        if(e) e.preventDefault(); // Stop page reload

        if (!deptModal || !deptForm) {
            console.error("Error: Modal elements not found");
            return;
        }

        // Reset Form & Clear ID
        deptForm.reset();
        document.getElementById('deptId').value = ''; 
        // Update Title
        const title = document.getElementById('modalTitle');
        if(title) title.innerText = 'Add New Department';
        // Show Modal
        deptModal.classList.remove('hidden');
    }

    // ==========================================
    // 3. OPEN "MODIFY DEPARTMENT" MODAL
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-dept-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); 
                if (!deptModal) return;

                // Get Data from Button
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const desc = this.getAttribute('data-description');

                // Fill Form Inputs
                document.getElementById('deptId').value = id;
                document.getElementById('deptName').value = name;
                document.getElementById('deptDesc').value = desc;

                // Update Title
                const title = document.getElementById('modalTitle');
                if(title) title.innerText = 'Modify Department';

                // Show Modal
                deptModal.classList.remove('hidden');
            });
        });
    });

    // ==========================================
    // 4. CLOSE MODAL (Connected to Cancel Button)
    // ==========================================
    function closeModal() {
        if(deptModal) {
            deptModal.classList.add('hidden');
        }
    }
