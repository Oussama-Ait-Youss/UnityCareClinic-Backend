<?php
// Page Specific Configuration
$pageTitle = "Unity Care - Patients";

// We don't set $headerTitle text here, we let header.php handle the translation array first
include '../dashboard/header.php'; // Loads $t
include '../config/connection.php'; 

// Use Translation for Header Title
$headerTitle = $t['patient_management'] ?? 'Patient Management'; // Fallback if key missing
?>

<?php 
    // Query
    $PatientQuery  = 'SELECT id,first_name,last_name,gender,email,phone,address FROM patients limit 10';
    // Execute Queries
    $PatientQueryResult = mysqli_query($conn, $PatientQuery);
?>

<div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
    
    <a href="#" 
       onclick="openAddPatientModal(event)"
       class="inline-flex items-center justify-center bg-[#22c55e] hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-medium transition-all shadow-md hover:shadow-lg gap-2">
       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
       <?php echo $t['add_patient'] ?? 'Add New Patient'; ?>
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
                   placeholder="<?php echo $t['search_placeholder'] ?? 'Search...'; ?>" 
                   aria-label="Search">
        </div>

        <div class="relative w-full md:w-40">
            <select class="block w-full pl-3 pr-10 py-3 text-base border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-xl bg-white shadow-sm appearance-none cursor-pointer">
                <option><?php echo $t['all_patients'] ?? 'All Patients'; ?></option>
                <option>Male</option>
                <option>Female</option>
                <option>Recent</option>
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
                <th class="py-3 font-semibold"><?php echo $t['id']; ?></th>
                <th class="py-3 font-semibold"><?php echo $t['name']; ?></th>
                <th class="py-3 font-semibold"><?php echo $t['email']; ?></th>
                <th class="py-3 font-semibold"><?php echo $t['gender']; ?></th>
                <th class="py-3 font-semibold"><?php echo $t['phone']; ?></th>
                <th class="py-3 font-semibold text-right"><?php echo $t['actions'] ?? 'Actions'; ?></th>
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
                            <a href='edit.php' 
                               class='edit-btn text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-xs px-3 py-2 transition-all shadow-sm'
                               data-id='{$row['id']}'
                               data-firstname='{$row['first_name']}'
                               data-lastname='{$row['last_name']}'
                               data-email='{$row['email']}'
                               data-gender='{$row['gender']}'
                               data-phone='{$row['phone']}'>
                               {$t['modify']}
                            </a>
                            
                            <a href='delete.php?id={$row['id']}' 
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

<div id="patientModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            
            <form action="./save_patient.php" method="POST" id="patientForm" novalidate>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modalTitle"><?php echo $t['modify_patient']; ?></h3>
                    
                    <input type="hidden" name="id" id="patientId">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700"><?php echo $t['first_name'] ?? 'First Name'; ?></label>
                            <input type="text" name="first_name" id="patientFirstName" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700"><?php echo $t['last_name'] ?? 'Last Name'; ?></label>
                            <input type="text" name="last_name" id="patientLastName" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700"><?php echo $t['email']; ?></label>
                        <input type="email" name="email" id="patientEmail" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700"><?php echo $t['phone']; ?></label>
                        <input type="text" name="phone" id="patientPhone" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700"><?php echo $t['gender']; ?></label>
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
                    <button type="button" onclick="closeModalpatient()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        <?php echo $t['cancel']; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
            
<?php 
    include '../dashboard/footer.php';
?>