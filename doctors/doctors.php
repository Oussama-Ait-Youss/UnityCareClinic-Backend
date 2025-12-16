<?php
// Page Specific Configuration
$pageTitle = "Unity Care - Doctors";
$headerTitle = "Doctors Management";


include '../dashboard/header.php';
include '../config/connection.php'; 
?>
<?php 
        // Query
        $PatientQuery  = 'SELECT DOC.id,DOC.first_name,DOC.last_name,DOC.email,DOC.specialty,DEP.name 
        FROM doctors DOC
        JOIN departments DEP ON DEP.id = DOC.department_id
        limit 10';


        // Execute Queries
        $PatientQueryResult = mysqli_query($conn, $PatientQuery);


        // Fetch Counts 
        $row_patients = mysqli_fetch_assoc($PatientQueryResult);



?>
<div class="overflow-x-auto bg-white rounded-[2rem] p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs text-gray-400 uppercase border-b border-gray-100">
                            <th class="py-3 font-semibold">ID</th>
                            <th class="py-3 font-semibold">Doctor Name</th>
                            <th class="py-3 font-semibold">Email</th>
                            <th class="py-3 font-semibold">Specialty</th>
                            <th class="py-3 font-semibold">Department Name</th>
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
                                    <td class='py-4 font-medium'>{$row['specialty']}</td>
                                    <td class='py-4 text-gray-500'>{$row['name']}</td>
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
<?php 
    include '../dashboard/footer.php';
?>