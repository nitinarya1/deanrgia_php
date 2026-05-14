<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/includes/auth_check.php';

$db = getDB();

// Handle delete
if (isset($_GET['delete'])) {
    $db->prepare("DELETE FROM contacts WHERE id = ?")->execute([intval($_GET['delete'])]);
    header('Location: ' . $_SERVER['PHP_SELF'] . '?deleted=1');
    exit;
}

$messages = $db->query("SELECT * FROM contacts ORDER BY created_at DESC")->fetchAll();

include __DIR__ . '/includes/admin_header.php';
?>

<?php if (isset($_GET['deleted'])): ?>
<div class="mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-sm font-medium">Message deleted successfully!</div>
<?php endif; ?>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200">
        <h3 class="text-lg font-bold text-slate-900">Contact Messages (<?php echo count($messages); ?>)</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">#</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Subject</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Message</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($messages)): ?>
                    <tr><td colspan="7" class="px-4 py-8 text-center text-slate-400">No contact messages yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($messages as $i => $msg): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 text-slate-400"><?php echo $i + 1; ?></td>
                        <td class="px-4 py-3 text-slate-700 font-medium"><?php echo sanitize($msg['name']); ?></td>
                        <td class="px-4 py-3 text-slate-700"><?php echo sanitize($msg['email']); ?></td>
                        <td class="px-4 py-3 text-slate-700 max-w-[150px] truncate"><?php echo sanitize($msg['subject']); ?></td>
                        <td class="px-4 py-3 text-slate-600 max-w-[200px] truncate"><?php echo sanitize(substr($msg['message'], 0, 80)); ?></td>
                        <td class="px-4 py-3 text-slate-500 text-xs"><?php echo formatDate($msg['created_at'], 'M d, Y H:i'); ?></td>
                        <td class="px-4 py-3 text-right">
                            <a href="?delete=<?php echo $msg['id']; ?>" onclick="return confirm('Delete this message?')" class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
