<?php
// Page Specific Configuration
$pageTitle = "Unity Care - Patients";
$headerTitle = "Patient - Management";


include '../dashboard/header.php';
include '../config/connection.php'; 
?>
<?php 
        // Query
        $PatientQuery  = 'SELECT id,first_name,last_name,gender,email,phone,address FROM patients limit 10';


        // Execute Queries
        $PatientQueryResult = mysqli_query($conn, $PatientQuery);


        // Fetch Counts 
        $row_patients = mysqli_fetch_assoc($PatientQueryResult);



?>
<a href="#" 
   onclick="openAddPatientModal()"
   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-[0.5rem] text-sm font-medium transition-colors">
   + Add Patient
</a>

<div class="overflow-x-auto bg-white rounded-[2rem] p-6">
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
                                        <a href='edit.php' 
                                            class='edit-btn inline-block text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-1 shadow-md transition-all'
                                            data-id='{$row['id']}'
                                            data-firstname='{$row['first_name']}'
                                            data-lastname='{$row['last_name']}'
                                            data-email='{$row['email']}'
                                            data-gender='{$row['gender']}'
                                            data-phone='{$row['phone']}'>
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

<!-- modal modify patient -->
<div id="patientModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            
            <form action="./save_patient.php" method="POST" id="patientForm" novalidate>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modalTitle">Modify Patient</h3>
                    
                    <input type="hidden" name="id" id="patientId">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" name="first_name" id="patientFirstName" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <p id="error-firstname" class="text-red-500 text-xs mt-1 hidden">First name is required</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" name="last_name" id="patientLastName" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <p id="error-lastname" class="text-red-500 text-xs mt-1 hidden">Last name is required</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" id="patientEmail" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <p id="error-email" class="text-red-500 text-xs mt-1 hidden">Valid email is required</p>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="phone" id="patientPhone" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <p id="error-phone" class="text-red-500 text-xs mt-1 hidden">Phone number is required (min 8 digits)</p>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender" id="patientGender" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white p-2.5 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <p id="error-gender" class="text-red-500 text-xs mt-1 hidden">Please select a gender</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 sm:ml-3 sm:w-auto sm:text-sm">
                        Save Changes
                    </button>
                    <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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