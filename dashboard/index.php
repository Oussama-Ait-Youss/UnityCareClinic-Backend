<?php
$pageTitle = "Unity Care - Dashboard";

// Include header first to load the language array ($t)
include './header.php'; 
include '../config/connection.php'; 

// Use translation for the greeting
$headerTitle = $t['welcome'] . ", Dr. Oussama!";
?>

<?php
    // ===============================================
    // 1. DATABASE QUERIES (No changes needed here)
    // ===============================================

    // Patient List Query
    $PatientQuery           = 'SELECT id,first_name,last_name,gender,email,phone,address FROM patients limit 10';
    $PatientQueryResult     = mysqli_query($conn, $PatientQuery);

    // Counters
    $PatientQueryCounter    = 'SELECT COUNT(*) AS counter FROM patients';
    $DoctorsQueryCounter    = 'SELECT COUNT(*) as counter FROM doctors';
    $DepartmentsQueryCounter    = 'SELECT COUNT(*) as counter FROM departments';

    $PatientQueryCounterResult  = mysqli_query($conn, $PatientQueryCounter);
    $DoctorsQueryCounterResult  = mysqli_query($conn, $DoctorsQueryCounter);
    $DepartmentsQueryCounterResult  = mysqli_query($conn, $DepartmentsQueryCounter);

    $row_patients = mysqli_fetch_assoc($PatientQueryCounterResult);
    $row_doctors  = mysqli_fetch_assoc($DoctorsQueryCounterResult);
    $row_departments = mysqli_fetch_assoc($DepartmentsQueryCounterResult);
    
    $totalPatients = $row_patients['counter'];
    $totalDoctors  = $row_doctors['counter'];
    $totalDepts    = $row_departments['counter']; 

    // Departments List (for Dropdown)
    $deptQuery = "SELECT id, name FROM departments";
    $deptResult = mysqli_query($conn, $deptQuery);
    $departments = [];
    if ($deptResult) {
        while($dept = mysqli_fetch_assoc($deptResult)){
            $departments[] = $dept;
        }
    }

    // --- CHART 1: Doctors per Department ---
    $chartDeptQuery = "SELECT dep.name, COUNT(doc.id) as total 
                        FROM departments dep 
                        LEFT JOIN doctors doc ON dep.id = doc.department_id 
                        GROUP BY dep.id";
    $chartDeptResult = mysqli_query($conn, $chartDeptQuery);

    $deptLabels = [];
    $deptCounts = [];

    while($row = mysqli_fetch_assoc($chartDeptResult)) {
        $deptLabels[] = $row['name'];
        $deptCounts[] = $row['total'];
    }

    // --- CHART 2: Patient Demographics (Gender) ---
    $chartGenderQuery = "SELECT gender, COUNT(*) as total FROM patients GROUP BY gender";
    $chartGenderResult = mysqli_query($conn, $chartGenderQuery);

    $genderLabels = [];
    $genderCounts = [];

    while($row = mysqli_fetch_assoc($chartGenderResult)) {
        $genderLabels[] = $row['gender'];
        $genderCounts[] = $row['total'];
    }
?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
        
        <a href="../auth/logout.php" class="bg-[#22c55e] text-white p-6 rounded-[2rem] flex flex-col justify-between hover:scale-[1.02] transition cursor-pointer h-40 group">
            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-arrow-right-to-bracket text-lg"></i>
            </div>
            <div>
                <span class="block text-sm opacity-90 mb-1"><?php echo $t['quick_action']; ?></span>
                <h3 class="text-xl font-bold"><?php echo $t['logout']; ?></h3>
            </div>
        </a>

        <a href="../doctors/save_doctor.php" onclick="openAddDoctorModal(event)" class="bg-[#111827] text-white p-6 rounded-[2rem] flex flex-col justify-between hover:scale-[1.02] transition cursor-pointer h-40">
            <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-user-doctor text-lg"></i>
            </div>
            <div>
                <span class="block text-sm opacity-70 mb-1"><?php echo $t['quick_action']; ?></span>
                <h3 class="text-xl font-bold"><?php echo $t['add_doctor']; ?></h3>
            </div>
        </a>

        <div class="bg-white p-6 rounded-[2rem] flex flex-col justify-between h-40 shadow-sm">
            <div>
                <h4 class="font-bold text-gray-800 mb-1"><?php echo $t['total_patients']; ?></h4>
                <p class="text-xs text-gray-500">Compared to (10 last month)</p>
            </div>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-bold text-gray-900"><?php echo $totalPatients ?? '0'; ?></span>
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-lg text-xs font-bold mb-1">+5%</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] flex flex-col justify-between h-40 shadow-sm">
            <div>
                <h4 class="font-bold text-gray-800 mb-1"><?php echo $t['total_doctors']; ?></h4>
                <p class="text-xs text-gray-500">Active medical staff</p>
            </div>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-bold text-gray-900"><?php echo $totalDoctors ?? '0'; ?></span>
                <span class="bg-red-100 text-red-600 px-2 py-1 rounded-lg text-xs font-bold mb-1">-2%</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] flex flex-col justify-between h-40 shadow-sm">
            <div>
                <h4 class="font-bold text-gray-800 mb-1"><?php echo $t['departments']; ?></h4>
                <p class="text-xs text-gray-500">Operational units</p>
            </div>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-bold text-gray-900"><?php echo $totalDepts ?? '0'; ?></span>
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-lg text-xs font-bold mb-1">+1</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white rounded-[2rem] p-6 lg:p-8 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-800"><?php echo $t['recent_patients']; ?></h3>
                    <p class="text-sm text-gray-500">Latest registrations</p>
                </div>
                <button class="text-sm font-semibold text-gray-600 bg-gray-100 px-4 py-2 rounded-xl hover:bg-gray-200 transition">
                    <?php echo $t['view_all']; ?>
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs text-gray-400 uppercase border-b border-gray-100">
                            <th class="py-3 font-semibold"><?php echo $t['id']; ?></th>
                            <th class="py-3 font-semibold"><?php echo $t['name']; ?></th>
                            <th class="py-3 font-semibold"><?php echo $t['email']; ?></th>
                            <th class="py-3 font-semibold"><?php echo $t['gender']; ?></th>
                            <th class="py-3 font-semibold"><?php echo $t['phone']; ?></th>
                            <th class="py-3 font-semibold text-right"><?php echo $t['modify']; ?> / <?php echo $t['delete']; ?></th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <?php
                        while ($row = mysqli_fetch_assoc($PatientQueryResult)) { 
                                $fullname = $row['first_name'] . ' ' . $row['last_name'];
                                echo "
                                <tr class='group hover:bg-gray-50 transition border-b border-gray-100 last:border-0'>
                                    <td class='py-4 pl-4 font-medium text-gray-500'>{$row['id']}</td>
                                    <td class='py-4'>
                                        <div class='flex items-center gap-3'>
                                            <div class='w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold'>
                                                " . strtoupper(substr($row['first_name'], 0, 1)) . "
                                            </div>
                                            <span class='font-bold text-gray-700'> {$fullname} </span>
                                        </div>
                                    </td>
                                    <td class='py-4 text-gray-500'>{$row['email']}</td>
                                    <td class='py-4 font-medium'>{$row['gender']}</td>
                                    <td class='py-4 text-gray-500'>{$row['phone']}</td>
                                    <td class='py-4 text-right pr-4'>
                                    <div class='flex items-center justify-end gap-2'>
                                        <a href='../patients/edit.php' 
                                            class='edit-btn text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-xs px-3 py-2 transition-all shadow-sm'
                                            data-id='{$row['id']}'
                                            data-firstname='{$row['first_name']}'
                                            data-lastname='{$row['last_name']}'
                                            data-email='{$row['email']}'
                                            data-gender='{$row['gender']}'
                                            data-phone='{$row['phone']}'>
                                            {$t['modify']}
                                        </a>
                                        
                                        <a href='./delete.php?id={$row['id']}' 
                                           class='text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-xs px-3 py-2 transition-all shadow-sm'>
                                            {$t['delete']}
                                        </a>
                                    </div>
                                    </td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <div class="bg-white rounded-[2rem] p-6 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-bold text-gray-800"><?php echo $t['statistics']; ?></h3>
                        <p class="text-xs text-gray-500"><?php echo $t['doctors_per_dept']; ?></p>
                    </div>
                    <button class="bg-gray-100 p-2 rounded-lg text-xs font-bold text-gray-600">Weekly</button>
                </div>
                <div class="relative h-48 w-full">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-6 shadow-sm flex-1">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-bold text-gray-800"><?php echo $t['top_categories']; ?></h3>
                        <p class="text-xs text-gray-500"><?php echo $t['patient_demographics']; ?></p>
                    </div>
                    <button class="bg-gray-100 p-2 rounded-lg text-xs font-bold text-gray-600">View</button>
                </div>
                <div class="relative h-48 w-full flex justify-center">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>
        </div>
        
    </div>

    <div id="patientModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                
                <form action="../patients/save_patient.php" method="POST" id="patientForm" novalidate>
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modalTitle"><?php echo $t['modify_patient']; ?></h3>
                        
                        <input type="hidden" name="id" id="patientId">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" name="first_name" id="patientFirstName" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" name="last_name" id="patientLastName" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="patientEmail" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone" id="patientPhone" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Gender</label>
                            <select name="gender" id="patientGender" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 sm:ml-3 sm:w-auto sm:text-sm">
                            <?php echo $t['save_changes']; ?>
                        </button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            <?php echo $t['cancel']; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="doctorModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                
                <form action="save_doctor.php" method="POST" id="doctorForm">
                    <div class="bg-white px-8 pt-8 pb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6" id="modalTitle">Modify Doctor</h3>
                        <input type="hidden" name="id" id="doctorId">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" name="first_name" id="docFirstName" required class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 px-3 bg-gray-50 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" name="last_name" id="docLastName" required class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 px-3 bg-gray-50 border">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" id="docEmail" required class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 px-3 bg-gray-50 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="text" name="phone" id="docPhone" class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 px-3 bg-gray-50 border">
                            </div>
                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Specialty</label>
                            <input type="text" name="specialty" id="docSpecialty" class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 px-3 bg-gray-50 border">
                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                            <select name="department_id" id="docDepartment" required class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 px-3 bg-gray-50 border">
                                <option value="">Select Department</option>
                                <?php foreach($departments as $dept): ?>
                                    <option value="<?php echo $dept['id']; ?>"><?php echo $dept['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-8 py-5 flex flex-row-reverse gap-3">
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-blue-600 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none transition-colors">
                            <?php echo $t['save_changes']; ?>
                        </button>
                        <button type="button" onclick="closeModaldoctor()" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                            <?php echo $t['cancel']; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // --- Data from PHP ---
        const deptLabels = <?php echo json_encode($deptLabels); ?>;
        const deptData = <?php echo json_encode($deptCounts); ?>;
        const genderLabels = <?php echo json_encode($genderLabels); ?>;
        const genderData = <?php echo json_encode($genderCounts); ?>;

        const ctxBar = document.getElementById('barChart');
        if (ctxBar) {
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: deptLabels,
                    datasets: [{
                        label: 'Number of Doctors',
                        data: deptData,
                        backgroundColor: '#3b82f6', // Blue-500
                        borderRadius: 8,
                        barThickness: 30
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 2] }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // --- Donut Chart (Patient Gender) ---
        const ctxDonut = document.getElementById('donutChart');
        if (ctxDonut) {
            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: genderLabels,
                    datasets: [{
                        data: genderData,
                        backgroundColor: [
                            '#22c55e', // Green
                            '#3b82f6', // Blue
                            '#f59e0b'  // Orange (for Other)
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: { usePointStyle: true }
                        }
                    }
                }
            });
        }
    </script>

<?php include 'footer.php'; ?>