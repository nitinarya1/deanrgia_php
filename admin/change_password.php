<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/includes/auth_check.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = 'All fields are required';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'New passwords do not match';
    } elseif (strlen($newPassword) < 6) {
        $error = 'New password must be at least 6 characters long';
    } else {
        $db = getDB();
        $stmt = $db->prepare("SELECT password FROM admins WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($currentPassword, $admin['password'])) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $db->prepare("UPDATE admins SET password = ? WHERE id = ?");
            if ($updateStmt->execute([$hashedPassword, $_SESSION['admin_id']])) {
                $success = 'Password updated successfully';
            } else {
                $error = 'Failed to update password. Please try again.';
            }
        } else {
            $error = 'Current password is incorrect';
        }
    }
}

include __DIR__ . '/includes/admin_header.php';
?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-xl font-bold text-slate-900">Change Administrative Password</h3>
            <div class="w-10 h-10 rounded-full bg-teal-50 flex items-center justify-center text-teal-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
        </div>
        
        <div class="p-8">
            <?php if ($error): ?>
            <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-600 text-sm font-medium border border-red-100 flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <?php echo sanitize($error); ?>
            </div>
            <?php endif; ?>

            <?php if ($success): ?>
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-medium border border-emerald-100 flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                <?php echo sanitize($success); ?>
            </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Current Password</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:bg-white transition-all">
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">New Password</label>
                        <input type="password" name="new_password" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Confirm New Password</label>
                        <input type="password" name="confirm_password" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:bg-white transition-all">
                    </div>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="flex-1 py-4 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold tracking-wide transition-all shadow-lg shadow-slate-900/10">
                        Update Password
                    </button>
                    <a href="<?php echo BASE_URL; ?>/admin/" class="flex-1 py-4 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold tracking-wide transition-all text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="mt-8 p-6 rounded-2xl bg-teal-50 border border-teal-100 flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-teal-100/50 flex items-center justify-center text-teal-600 shrink-0">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <p class="text-sm text-teal-800 leading-relaxed">
            <strong>Security Tip:</strong> A strong password should contain at least 8 characters, including numbers, uppercase letters, and special characters. Avoid using easily guessable information like your name or institution name.
        </p>
    </div>
</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
