<?php
// Page Specific Configuration
$pageTitle = "Unity Care - Doctors";
$headerTitle = "Departments Management";


include '../dashboard/header.php';
include '../config/connection.php'; 
?>
<?php 
        // Query
        $TotalDocotorsDep = 'SELECT 
                             dep.id, 
                             dep.name, 
                             dep.description, 
                             COUNT(doc.id) as total_doctors
                             FROM departments dep
                             LEFT JOIN doctors doc ON dep.id = doc.department_id
                             GROUP BY dep.id;
                            ';


        // Execute Queries
        $TotalDocotorsDepRes = mysqli_query($conn, $TotalDocotorsDep);


        // Fetch Counts 
        $row_departments = mysqli_fetch_assoc($TotalDocotorsDepRes);



?>
<div class="overflow-x-auto bg-white rounded-[2rem] p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs text-gray-400 uppercase border-b border-gray-100">
                            <th class="py-3 font-semibold">ID</th>
                            <th class="py-3 font-semibold">Departments Name</th>
                            <th class="py-3 font-semibold">Description</th>
                            <th class="py-3 font-semibold">Number of Doctors</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <?php
                        while ($row = mysqli_fetch_assoc($TotalDocotorsDepRes)) { 
                                echo "
<tr class='group hover:bg-gray-50 transition border-b border-gray-100 last:border-0'>
    
    <td class='py-4 pl-4 font-medium text-gray-500'>{$row['id']}</td>

    <td class='py-4'>
        <div class='flex items-center gap-3'>
            <div class='w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold shadow-sm'>
                " . strtoupper(substr($row['name'], 0, 1)) . "
            </div>
            <span class='font-bold text-gray-700'>{$row['name']}</span>
        </div>
    </td>

    <td class='py-4 text-gray-500 max-w-xs truncate'>
        {$row['description']}
    </td>

    <td class='py-4'>
        <span class='inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100'>
            {$row['total_doctors']} Doctors
        </span>
    </td>

    <td class='py-4 text-right pr-4'>
        <div class='flex items-center justify-end gap-2'>
            <a href='modify_department.php?id={$row['id']}' 
               class='text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-xs px-3 py-2 transition-all shadow-sm'>
               Modify
            </a>
            
            <a href='delete_department.php?id={$row['id']}' 
               class='text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-xs px-3 py-2 transition-all shadow-sm'>
               Delete
            </a>
        </div>
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