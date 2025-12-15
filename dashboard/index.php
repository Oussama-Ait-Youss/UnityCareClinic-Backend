<?php
// Page Specific Configuration
$pageTitle = "Unity Care - Dashboard";
$headerTitle = "Good morning, Dr. Oussama!";


include './header.php';
include '../config/connection.php'; 
?>
<?php
    // 1. Define Queries
    $PatientQuery           = 'SELECT id,first_name,last_name,gender,email,phone,address FROM patients limit 10';
    $PatientQueryCounter    = 'SELECT COUNT(*) AS counter FROM patients';
    $DoctorsQueryCounter    = 'SELECT COUNT(*) as counter FROM doctors';
    $DepartmentsQueryCounter    = 'SELECT COUNT(*) as counter FROM departments';

    // 2. Execute Queries
    $PatientQueryResult         = mysqli_query($conn, $PatientQuery);
    $PatientQueryCounterResult  = mysqli_query($conn, $PatientQueryCounter);
    $DoctorsQueryCounterResult  = mysqli_query($conn, $DoctorsQueryCounter);
    $DepartmentsQueryCounterResult  = mysqli_query($conn, $DepartmentsQueryCounter);

    // 3. Fetch Counts 
    // (Do NOT fetch $PatientQueryResult here, or you lose the first patient in your table!)
    
    $row_patients = mysqli_fetch_assoc($PatientQueryCounterResult);
    $row_doctors  = mysqli_fetch_assoc($DoctorsQueryCounterResult);
    $row_departments = mysqli_fetch_assoc($DepartmentsQueryCounterResult);
    
    // 4. Assign Variables
    $totalPatients = $row_patients['counter'];
    $totalDoctors  = $row_doctors['counter'];
    $totalDepts    = $row_departments['counter']; 

    
    // Note: You labeled this $totalDepts in your code, but the query counts Doctors. 
    // If you need Departments, you need a separate query.
?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
        
        <a href="patients/create.php" class="bg-[#22c55e] text-white p-6 rounded-[2rem] flex flex-col justify-between hover:scale-[1.02] transition cursor-pointer h-40 group">
            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-arrow-right-to-bracket text-lg"></i>
            </div>
            <div>
                <span class="block text-sm opacity-90 mb-1">Quick Action</span>
                <h3 class="text-xl font-bold">Log Out</h3>
            </div>
        </a>

        <a href="doctors/create.php" class="bg-[#111827] text-white p-6 rounded-[2rem] flex flex-col justify-between hover:scale-[1.02] transition cursor-pointer h-40">
            <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-user-doctor text-lg"></i>
            </div>
            <div>
                <span class="block text-sm opacity-70 mb-1">Quick Action</span>
                <h3 class="text-xl font-bold">Add Doctor</h3>
            </div>
        </a>

        <div class="bg-white p-6 rounded-[2rem] flex flex-col justify-between h-40 shadow-sm">
            <div>
                <h4 class="font-bold text-gray-800 mb-1">Total Patients</h4>
                <p class="text-xs text-gray-500">Compared to (10 last month)</p>
            </div>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-bold text-gray-900"><?php echo $totalPatients ?? '0'; ?></span>
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-lg text-xs font-bold mb-1">+5%</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] flex flex-col justify-between h-40 shadow-sm">
            <div>
                <h4 class="font-bold text-gray-800 mb-1">Total Doctors</h4>
                <p class="text-xs text-gray-500">Active medical staff</p>
            </div>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-bold text-gray-900"><?php echo $totalDoctors ?? '0'; ?></span>
                <span class="bg-red-100 text-red-600 px-2 py-1 rounded-lg text-xs font-bold mb-1">-2%</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] flex flex-col justify-between h-40 shadow-sm">
            <div>
                <h4 class="font-bold text-gray-800 mb-1">Departments</h4>
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
                    <h3 class="text-xl font-bold text-gray-800">Recent Patients</h3>
                    <p class="text-sm text-gray-500">Latest registrations</p>
                </div>
                <button class="text-sm font-semibold text-gray-600 bg-gray-100 px-4 py-2 rounded-xl hover:bg-gray-200 transition">
                    View All
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs text-gray-400 uppercase border-b border-gray-100">
                            <th class="py-3 font-semibold">ID</th>
                            <th class="py-3 font-semibold">Patient Name</th>
                            <th class="py-3 font-semibold">Email</th>
                            <th class="py-3 font-semibold">Gender</th>
                            <th class="py-3 font-semibold">Phone</th>
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
                                        <a href='modify.php?id={$row['id']}' 
                                           class='inline-block text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-1 shadow-md transition-all'>
                                           Modify
                                        </a>
                                    </td>
                                    <td class='py-4 text-right pr-4'>
                                        <a href='delete.php?id={$row['id']}' 
                                           class='inline-block text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-1 shadow-md transition-all'>
                                           Delete
                                        </a>
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
                        <h3 class="font-bold text-gray-800">Statistics</h3>
                        <p class="text-xs text-gray-500">Doctors per Department</p>
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
                        <h3 class="font-bold text-gray-800">Top Categories</h3>
                        <p class="text-xs text-gray-500">Patient Demographics</p>
                    </div>
                    <button class="bg-gray-100 p-2 rounded-lg text-xs font-bold text-gray-600">View</button>
                </div>
                <div class="relative h-48 w-full flex justify-center">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // You can add your Chart.js initialization logic here
    </script>

<?php include 'footer.php'; ?>