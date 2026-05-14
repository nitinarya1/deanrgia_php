<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Handle login form submission
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: ' . BASE_URL . '/admin/');
            exit;
        } else {
            $error = 'Invalid username or password';
        }
    } else {
        $error = 'Please enter both username and password';
    }
}

// If already logged in, redirect
if (isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/admin/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - RGIA MNNIT</title>
    <link rel="icon" type="image/jpeg" href="<?php echo BASE_URL; ?>/public/mnnitlogo.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] } } } }</script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
</head>
<body class="font-sans antialiased">
<div class="min-h-screen flex text-slate-900">
    <!-- Left side branding -->
    <div class="hidden lg:flex lg:w-5/12 relative bg-slate-900 items-center justify-center p-12 overflow-hidden shrink-0">
        <div class="absolute inset-0 z-0 bg-gradient-to-br from-teal-900/90 via-slate-900/90 to-slate-900"></div>
        <div class="relative z-10 w-full max-w-lg text-white">
            <div class="w-20 h-20 mb-10 bg-white rounded-2xl p-2.5 shadow-2xl flex items-center justify-center">
                <img src="<?php echo BASE_URL; ?>/public/mnnitlogo.jpg" alt="MNNIT Logo" class="w-full h-full object-contain">
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight tracking-tight">Resource Generation <br>&amp; International Affairs</h1>
            <p class="text-teal-50/90 text-lg leading-relaxed mb-10 border-l-2 border-teal-500/50 pl-5">Welcome to the secure administrative portal. Manage global partnerships, institutional directories, and official announcements for MNNIT Allahabad.</p>
            <div class="flex items-center gap-3 text-sm font-medium text-teal-200/80 bg-slate-900/50 w-fit px-4 py-2 rounded-full backdrop-blur-sm border border-white/5">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-teal-500"></span>
                </span>
                Secure Connection
            </div>
        </div>
    </div>
    <!-- Right side login form -->
    <div class="w-full lg:w-7/12 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-white relative">
        <div class="w-full max-w-md animate-fade-in-up">
            <div class="lg:hidden text-center mb-10">
                <img src="<?php echo BASE_URL; ?>/public/mnnitlogo.jpg" alt="MNNIT Logo" class="w-16 h-16 mx-auto mb-4 drop-shadow-sm">
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">RGIA Admin Portal</h2>
            </div>
            <div class="mb-10 lg:text-left text-center">
                <h2 class="text-3xl font-bold text-slate-900 mb-2 tracking-tight">Sign in</h2>
                <p class="text-slate-500 font-medium">Please enter your administrative credentials.</p>
            </div>
            <form method="POST" class="space-y-6">
                <?php if ($error): ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100 flex items-start gap-3 animate-slide-in-left">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <?php echo sanitize($error); ?>
                </div>
                <?php endif; ?>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input type="text" name="username" required class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:bg-white transition-all font-medium" placeholder="Enter your username">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input type="password" name="password" required class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:bg-white transition-all font-medium" placeholder="••••••••">
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full py-4 mt-4 bg-slate-900 hover:bg-slate-800 focus:ring-4 focus:ring-slate-900/20 text-white rounded-xl font-bold tracking-wide transition-all flex items-center justify-center gap-2 shadow-xl shadow-slate-900/10">
                    Sign In to Dashboard
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </button>
            </form>
            <div class="mt-14 pt-8 border-t border-slate-200 flex items-center justify-center">
                <a href="<?php echo BASE_URL; ?>/" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-teal-700 font-semibold transition-colors group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Return to Public Website
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
