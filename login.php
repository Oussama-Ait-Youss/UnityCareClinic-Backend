<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unity Care - Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hidden-form { display: none; }
        .fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center p-4">

    <div class="max-w-4xl w-full bg-white rounded-[2rem] shadow-xl overflow-hidden flex h-[600px]">
        
        <div class="hidden md:flex w-1/2 bg-blue-600 text-white flex-col justify-center items-center p-12 relative overflow-hidden">
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/medical-icons.png')]"></div>
            <div class="z-10 text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                    <i class="fa-solid fa-heart-pulse text-4xl text-white"></i>
                </div>
                <h2 class="text-3xl font-bold mb-4">Unity Care</h2>
                <p class="text-blue-100">Advanced Hospital Management System. Secure, Fast, and Reliable.</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center relative">
            
            <form id="loginForm" action="auth/authenticate.php" method="POST" class="fade-in space-y-5" onsubmit="return validateLogin()">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Welcome Back!</h2>
                    <p class="text-gray-500 text-sm">Please enter your details to sign in</p>
                </div>

                <?php if(isset($_GET['error'])) { ?>
                    <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg text-center border border-red-100">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php } ?>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fa-regular fa-envelope"></i></span>
                        <input type="email" name="email" id="loginEmail" class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 border focus:bg-white focus:border-blue-500 focus:ring-blue-500 p-3 text-sm transition-all" placeholder="admin@unitycare.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" id="loginPass" class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 border focus:bg-white focus:border-blue-500 focus:ring-blue-500 p-3 text-sm transition-all" placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    Log In
                </button>

                <p class="text-center text-sm text-gray-500 mt-6">
                    Don't have an account? 
                    <a href="#" onclick="toggleForms()" class="text-blue-600 font-bold hover:underline">Sign Up</a>
                </p>
            </form>

            <form id="signupForm" action="auth/register.php" method="POST" class="hidden-form fade-in space-y-4" onsubmit="return validateSignup()">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
                    <p class="text-gray-500 text-sm">Join the Unity Care team</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">First Name</label>
                        <input type="text" name="first_name" id="regFirst" class="block w-full rounded-lg border-gray-200 bg-gray-50 border p-2.5 text-sm" placeholder="John">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Last Name</label>
                        <input type="text" name="last_name" id="regLast" class="block w-full rounded-lg border-gray-200 bg-gray-50 border p-2.5 text-sm" placeholder="Doe">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
                    <input type="email" name="email" id="regEmail" class="block w-full rounded-lg border-gray-200 bg-gray-50 border p-2.5 text-sm" placeholder="name@example.com">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Password</label>
                    <input type="password" name="password" id="regPass" class="block w-full rounded-lg border-gray-200 bg-gray-50 border p-2.5 text-sm" placeholder="Min 8 chars">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Confirm Password</label>
                    <input type="password" id="regPassConfirm" class="block w-full rounded-lg border-gray-200 bg-gray-50 border p-2.5 text-sm" placeholder="Repeat password">
                    <p id="passError" class="text-red-500 text-xs mt-1 hidden">Passwords do not match</p>
                </div>

                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition-all shadow-md">
                    Create Account
                </button>

                <p class="text-center text-sm text-gray-500 mt-4">
                    Already have an account? 
                    <a href="#" onclick="toggleForms()" class="text-blue-600 font-bold hover:underline">Log In</a>
                </p>
            </form>

        </div>
    </div>

    <script>
        // 1. Toggle between Login and Signup
        function toggleForms() {
            const loginForm = document.getElementById('loginForm');
            const signupForm = document.getElementById('signupForm');
            
            if (loginForm.classList.contains('hidden-form')) {
                loginForm.classList.remove('hidden-form');
                signupForm.classList.add('hidden-form');
            } else {
                loginForm.classList.add('hidden-form');
                signupForm.classList.remove('hidden-form');
            }
        }

        // 2. Validate Login
        function validateLogin() {
            const email = document.getElementById('loginEmail').value;
            const pass = document.getElementById('loginPass').value;
            
            if (!email || !pass) {
                alert("Please fill in all fields.");
                return false;
            }
            return true;
        }

        // 3. Validate Signup
        function validateSignup() {
            const first = document.getElementById('regFirst').value;
            const last = document.getElementById('regLast').value;
            const email = document.getElementById('regEmail').value;
            const pass = document.getElementById('regPass').value;
            const confirm = document.getElementById('regPassConfirm').value;
            const errorText = document.getElementById('passError');

            if (!first || !last || !email || !pass) {
                alert("All fields are required.");
                return false;
            }

            if (pass.length < 8) {
                alert("Password must be at least 8 characters long.");
                return false;
            }

            if (pass !== confirm) {
                errorText.classList.remove('hidden');
                return false; // Stop submission
            } else {
                errorText.classList.add('hidden');
            }

            return true; // Allow submission
        }
    </script>
</body>
</html>