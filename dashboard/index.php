<?php
// Page Specific Configuration
$pageTitle = "Unity Care - Dashboard";
$headerTitle = "Good morning, Dr. Oussama!";

// Define the custom button for the header
$headerActionBtn = '
<a href="patients/create.php" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg shadow-indigo-500/30 transition flex items-center gap-2">
    <i class="fa-solid fa-plus"></i> New Patient
</a>';

include 'header.php'; 
include '../config/connection.php'; 
?>
<?php

    $query = 'SELECT id,first_name,last_name,gender,email,phone,address FROM patients limit 50' ;
    $result = mysqli_query($conn,$query);

    
?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
        
        <a href="patients/create.php" class="bg-[#22c55e] text-white p-6 rounded-[2rem] flex flex-col justify-between hover:scale-[1.02] transition cursor-pointer h-40 group">
            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-arrow-right-to-bracket text-lg"></i>
            </div>
            <div>
                <span class="block text-sm opacity-90 mb-1">Quick Action</span>
                <h3 class="text-xl font-bold">Add Patient</h3>
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
                            <th class="py-3 font-semibold text-right">address</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) { 
                            $fullname = $row['first_name'] . ' ' . $row['last_name'];
    echo "
    <tr class='group hover:bg-gray-50 transition'>
        <td class='py-4 font-medium text-gray-500'>{$row['id']}</td>
        <td class='py-4'>
            <div class='flex items-center gap-3'>
                <img src='https://i.pravatar.cc/150?u=1' class='w-10 h-10 rounded-full object-cover shadow-sm' alt='Avatar'>
                <span class='font-bold text-gray-700'> {$fullname} </span>
            </div>
        </td>
        <td class='py-4 text-gray-500'>{$row['email']}</td>
        <td class='py-4 font-medium'>{$row['gender']}</td>
        <td class='py-4 text-gray-500'>{$row['phone']}</td>
        <td class='py-4 text-right'>
            <span class='bg-purple-100 text-purple-600 px-3 py-1 rounded-lg text-xs font-bold'>{$row['address']}</span>
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