<?php
// conenction
require "../config/connection.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // If not logged in, redirect to login page
    header("Location: ../login.php");
    exit();
}


$pageTitle = $pageTitle ?? 'Unity Care';
$current_page = basename($_SERVER['PHP_SELF']);


// 1. Handle Language Switch
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    if (in_array($lang, ['en', 'fr'])) {
        $_SESSION['lang'] = $lang;
    }
}

// 2. Set Default
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// 3. Load File
$langFile = __DIR__ . '/../languages/' . $_SESSION['lang'] . '.php';
if (file_exists($langFile)) {
    $t = include($langFile);
} else {
    $t = include(__DIR__ . '/../languages/en.php');
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 p-4 lg:p-6 min-h-screen">

    <header class="bg-[#111827] text-white rounded-[2rem] p-6 lg:px-10 lg:py-8 shadow-xl mb-6 relative overflow-hidden">
        
        <div class="flex flex-col lg:flex-row justify-between items-center mb-8 gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-600 p-2 rounded-xl">
                    <i class="fa-solid fa-heart-pulse text-xl"></i>
                </div>
                <h1 class="text-xl font-bold tracking-wide">Unity Care</h1>
            </div>

            <nav class="bg-gray-800/50 backdrop-blur-md p-1.5 rounded-full flex gap-1">
                <a href="../dashboard/index.php" class="px-5 py-2 rounded-full text-sm font-medium transition 
                <?php echo ($current_page == 'index.php') ? 'bg-gray-700 shadow-sm' : 'text-gray-400 hover:bg-gray-700/50'; ?>">Dashboard</a>
                <a href="../patients/patients.php" class="px-5 py-2 rounded-full text-sm font-medium transition
                <?php echo ($current_page == 'patients.php') ? 'bg-gray-700 shadow-sm' : 'text-gray-400 hover:bg-gray-700/50'; ?>">Patients</a>
                <a href="../doctors/doctors.php" class="px-5 py-2 rounded-full text-sm font-medium transition 
                <?php echo ($current_page == 'doctors.php') ? 'bg-gray-700 shadow-sm' : 'text-gray-400 hover:bg-gray-700/50'; ?>">Doctors</a>
                <a href="../departments/departments.php" class="px-5 py-2 rounded-full text-sm font-medium transition 
                <?php echo ($current_page == 'departments.php') ? 'bg-gray-700 shadow-sm' : 'text-gray-400 hover:bg-gray-700/50'; ?>">Depts</a>
            </nav>

            <div class="flex items-center gap-4">
                <img src="https://ui-avatars.com/api/?name=Admin+User&background=3730a3&color=fff" alt="Admin" class="w-10 h-10 rounded-full border-2 border-gray-700">
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between items-end">
            <div class="flex flex-col justify-center">
                <h2 class="text-3xl lg:text-4xl font-bold mb-2"><?php echo $headerTitle ?? 'Welcome Back'; ?> </h2>
            </div>
            
            <?php if(isset($headerActionBtn)): ?>
                <div class="flex items-center gap-4 mt-4 md:mt-0">
                    <?php echo $headerActionBtn; ?>
                </div>
            <?php endif; ?>
        </div>
       <div class="flex gap-2">
    <a href="?<?php echo http_build_query(array_merge($_GET, ['lang' => 'en'])); ?>" 
       class="px-2 py-1 bg-white rounded hover:bg-gray-300 text-blue-900 text-xs font-bold <?php echo $_SESSION['lang'] == 'en' ? 'bg-blue-200 text-blue-900' : ''; ?>">
       EN
    </a>
    <a href="?<?php echo http_build_query(array_merge($_GET, ['lang' => 'fr'])); ?>" 
       class="px-2 py-1 bg-white rounded hover:bg-gray-300 text-blue-900 text-xs font-bold <?php echo $_SESSION['lang'] == 'fr' ? 'bg-blue-200 text-blue-900' : ''; ?>">
       FR
    </a>
</div>
    </header>
</body>
</html>