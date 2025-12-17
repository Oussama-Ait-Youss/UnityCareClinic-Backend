<?php
// Page Specific Configuration
$pageTitle = "Unity Care - Doctors";
$headerTitle = "Doctors Management";


include '../dashboard/header.php';
include '../config/connection.php'; 
?>
<?php 
        // Query
        $DoctorQuery  = 'SELECT DOC.id, DOC.first_name, DOC.last_name, DOC.email, DOC.phone, DOC.specialty, DOC.department_id, DEP.name
                    FROM doctors DOC
                    JOIN departments DEP ON DEP.id = DOC.department_id
                    LIMIT 10';


        // Execute Queries
        $DoctorQueryResult = mysqli_query($conn, $DoctorQuery);


        // Fetch Counts 
        $row_doctor = mysqli_fetch_assoc($DoctorQueryResult);
        // 1. Fetch Department Data
        $deptQuery = "SELECT id, name FROM departments";
        $deptResult = mysqli_query($conn, $deptQuery);
        
        $departments = []; // Initialize array
        
        // 2. Check if query worked
        if ($deptResult) {
            while($dept = mysqli_fetch_assoc($deptResult)){
                $departments[] = $dept;
            }
        } else {
            // Optional: Debug if query fails
            echo "Query Failed: " . mysqli_error($conn);
        }



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
                        while ($row = mysqli_fetch_assoc($DoctorQueryResult)) { 
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
                                         <a href='./save_doctor.php' 
                                            class='edit-doctor-btn inline-block text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-1 shadow-md transition-all'
                                            data-id='{$row['id']}'
                                            data-firstname='{$row['first_name']}'
                                            data-lastname='{$row['last_name']}'
                                            data-email='{$row['email']}'
                                            data-phone='{$row['phone']}' data-specialty='{$row['specialty']}'
                                            data-dept-id='{$row['department_id']}'> Modify
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
            <!-- doctor form modal -->
<div id="doctorModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeDoctorModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            
            <form action="save_doctor.php" method="POST" id="doctorForm">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="doctorModalTitle">Modify Doctor</h3>
                    
                    <input type="hidden" name="id" id="doctorId">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" name="first_name" id="docFirstName" required class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" name="last_name" id="docLastName" required class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="docEmail" required class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="phone" id="docPhone" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Specialty</label>
                        <input type="text" name="specialty" id="docSpecialty" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Department</label>
                        <select name="department_id" id="docDepartment" required class="mt-1 block w-full rounded-lg border border-gray-300 bg-white p-2.5 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a Department</option>
                            <?php 
                                // Loop through the departments we fetched at the top
                                foreach($departments as $dept) {
                                    echo "<option value='{$dept['id']}'>{$dept['name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                        Save Doctor
                    </button>
                    <button type="button" onclick="closeDoctorModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php 
    include '../dashboard/footer.php';
?>