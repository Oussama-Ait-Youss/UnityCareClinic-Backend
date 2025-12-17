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


        $DoctorQueryResult = mysqli_query($conn, $DoctorQuery);


        $row_doctor = mysqli_fetch_assoc($DoctorQueryResult);
        $deptQuery = "SELECT id, name FROM departments";
        $deptResult = mysqli_query($conn, $deptQuery);
        
        $departments = []; 
        
        if ($deptResult) {
            while($dept = mysqli_fetch_assoc($deptResult)){
                $departments[] = $dept;
            }
        } else {
            echo "Query Failed: " . mysqli_error($conn);
        }



?>
<div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
    
    <a href="./save_doctor.php" 
       onclick="openAddDoctorModal(event)"
       class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-medium transition-all shadow-md hover:shadow-lg gap-2">
       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
       Add New Doctor
    </a>

    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        
        <div class="relative group w-full md:w-64">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" 
                   class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm shadow-sm transition-all" 
                   placeholder="Search doctors..." 
                   aria-label="Search">
        </div>

        <div class="relative w-full md:w-48">
            <select class="block w-full pl-3 pr-10 py-3 text-base border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-xl bg-white shadow-sm appearance-none cursor-pointer">
                <option value="">All Departments</option>
                <?php foreach($departments as $dept): ?>
                    <option value="<?php echo $dept['id']; ?>"><?php echo $dept['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </div>
</div>
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
                                <div class='flex items-center justify-end gap-2'>
                                         <a href='./save_doctor.php' 
                                            class='edit-doctor-btn text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-xs px-3 py-2 transition-all shadow-sm'
                                            data-id='{$row['id']}'
                                            data-firstname='{$row['first_name']}'
                                            data-lastname='{$row['last_name']}'
                                            data-email='{$row['email']}'
                                            data-phone='{$row['phone']}' data-specialty='{$row['specialty']}'
                                            data-dept-id='{$row['department_id']}'> Modify
                                         </a>

                                        <a href='delete.php?id={$row['id']}' 
                                           class='text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-xs px-3 py-2 transition-all shadow-sm'>
                                           Delete
                                        </a>
                                    </td>
                                    </div>
                                </tr>";
}

                        ?>
                    </tbody>
                </table>
            </div>
            <!-- doctor form modal -->
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
                        Save Changes
                    </button>
                    <button type="button" onclick="closeModaldoctor()" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
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