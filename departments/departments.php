<?php
// Page Specific Configuration
$pageTitle = "Unity Care - Departments";
$headerTitle = "Departments Management";

include '../dashboard/header.php';
include '../config/connection.php'; 
?>

<?php 
    // Query: Get Dept info + Doctor Count
    $DeptQuery = 'SELECT dep.id, dep.name, dep.description, COUNT(doc.id) as total_doctors
                  FROM departments dep
                  LEFT JOIN doctors doc ON dep.id = doc.department_id
                  GROUP BY dep.id';

    // Execute Query
    $DeptResult = mysqli_query($conn, $DeptQuery);
    
    // NOTE: I removed the line "$row = mysqli_fetch_assoc..." that was here before.
    // It was causing the first department to disappear from the list.
?>

<div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
    

    <div class="relative group w-full md:w-64">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        </div>
        <input type="text" class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm shadow-sm" placeholder="Search departments...">
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-[2rem] p-6 shadow-sm border border-gray-50">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="text-xs text-gray-400 uppercase border-b border-gray-100">
                <th class="py-4 pl-4 font-semibold">ID</th>
                <th class="py-4 font-semibold">Department Name</th>
                <th class="py-4 font-semibold">Description</th>
                <th class="py-4 font-semibold">Stats</th>
                <th class="py-4 pr-4 font-semibold text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="text-sm">
            <?php
            if ($DeptResult) {
                while ($row = mysqli_fetch_assoc($DeptResult)) { 
                    $initial = strtoupper(substr($row['name'], 0, 1));
                    echo "
                    <tr class='group hover:bg-gray-50 transition border-b border-gray-100 last:border-0'>
                        <td class='py-4 pl-4 font-medium text-gray-500'>#{$row['id']}</td>
                        <td class='py-4'>
                            <div class='flex items-center gap-3'>
                                <div class='w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold shadow-sm'>
                                    {$initial}
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
                                <a href='#' 
                                   class='edit-dept-btn text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-xs px-3 py-2 transition-all shadow-sm'
                                   data-id='{$row['id']}'
                                   data-name='{$row['name']}'
                                   data-description='{$row['description']}'>
                                   Modify
                                </a>

                                <a href='./delete_department.php?id={$row['id']}' 
                                   onclick=\"return confirm('Are you sure? This department cannot be deleted if it has doctors.');\"
                                   class='text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-xs px-3 py-2 transition-all shadow-sm'>
                                   Delete
                                </a>
                            </div>
                        </td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<div id="deptModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            
            <form action="save_department.php" method="POST" id="deptForm">
                <div class="bg-white px-8 pt-8 pb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6" id="modalTitle">Modify Department</h3>
                    <input type="hidden" name="id" id="deptId">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Department Name</label>
                            <input type="text" name="name" id="deptName" required class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 px-3 bg-gray-50 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" id="deptDesc" rows="3" class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 px-3 bg-gray-50 border"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-8 py-5 flex flex-row-reverse gap-3">
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-blue-600 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none transition-colors">
                        Save Changes
                    </button>
                    <button type="button" onclick="closeModal()" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../dashboard/footer.php'; ?>
