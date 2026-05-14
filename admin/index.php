<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/includes/auth_check.php';

$db = getDB();
$stats = [
    'announcements' => $db->query("SELECT COUNT(*) FROM announcements")->fetchColumn(),
    'slides' => $db->query("SELECT COUNT(*) FROM slideshows")->fetchColumn(),
    'deans' => $db->query("SELECT COUNT(*) FROM deans")->fetchColumn(),
    'team' => $db->query("SELECT COUNT(*) FROM team")->fetchColumn(),
    'publications' => $db->query("SELECT COUNT(*) FROM publications")->fetchColumn(),
    'mou' => $db->query("SELECT COUNT(*) FROM mous")->fetchColumn(),
    'souvenirs' => $db->query("SELECT COUNT(*) FROM souvenirs")->fetchColumn(),
    'messages' => $db->query("SELECT COUNT(*) FROM contacts")->fetchColumn(),
];

$statCards = [
    ['title' => 'Announcements', 'count' => $stats['announcements'], 'color' => 'bg-purple-50 text-purple-600', 'link' => BASE_URL . '/admin/announcements.php'],
    ['title' => 'Slides', 'count' => $stats['slides'], 'color' => 'bg-blue-50 text-blue-600', 'link' => BASE_URL . '/admin/slideshow.php'],
    ['title' => 'Deans', 'count' => $stats['deans'], 'color' => 'bg-teal-50 text-teal-600', 'link' => BASE_URL . '/admin/deans.php'],
    ['title' => 'Team Members', 'count' => $stats['team'], 'color' => 'bg-indigo-50 text-indigo-600', 'link' => BASE_URL . '/admin/team.php'],
    ['title' => 'Publications', 'count' => $stats['publications'], 'color' => 'bg-rose-50 text-rose-600', 'link' => BASE_URL . '/admin/publications.php'],
    ['title' => 'MoUs', 'count' => $stats['mou'], 'color' => 'bg-amber-50 text-amber-600', 'link' => BASE_URL . '/admin/mou.php'],
    ['title' => 'Souvenirs', 'count' => $stats['souvenirs'], 'color' => 'bg-emerald-50 text-emerald-600', 'link' => BASE_URL . '/admin/souvenir.php'],
    ['title' => 'Messages', 'count' => $stats['messages'], 'color' => 'bg-orange-50 text-orange-600', 'link' => BASE_URL . '/admin/contacts.php'],
];

include __DIR__ . '/includes/admin_header.php';
?>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900 mb-2">Welcome to RGIA Admin</h1>
    <p class="text-slate-500">Manage all website content, deans, and announcements from one central hub.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php foreach ($statCards as $card): ?>
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] relative overflow-hidden group hover:border-teal-200 transition-colors">
        <div class="flex items-center justify-between mb-4 relative z-10">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center <?php echo $card['color']; ?>">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            </div>
            <span class="text-3xl font-bold text-slate-800"><?php echo $card['count']; ?></span>
        </div>
        <div class="relative z-10">
            <h3 class="text-slate-500 font-medium text-sm mb-3"><?php echo $card['title']; ?></h3>
            <a href="<?php echo $card['link']; ?>" class="inline-flex items-center text-sm font-semibold text-teal-600 hover:text-teal-800 transition-colors">
                Manage <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Quick Actions Section -->
<div class="mt-8 grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-teal-500 text-white flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
            Quick Actions
        </h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <a href="<?php echo BASE_URL; ?>/admin/change_password.php" class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-teal-50 hover:border-teal-200 transition-all group">
                <div class="w-12 h-12 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-500 group-hover:text-teal-600 group-hover:border-teal-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                </div>
                <div>
                    <p class="font-bold text-slate-900 text-sm">Change Password</p>
                    <p class="text-xs text-slate-500">Update your credentials</p>
                </div>
            </a>
            <a href="<?php echo BASE_URL; ?>/admin/mou.php" class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-amber-50 hover:border-amber-200 transition-all group">
                <div class="w-12 h-12 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-500 group-hover:text-amber-600 group-hover:border-amber-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                </div>
                <div>
                    <p class="font-bold text-slate-900 text-sm">See all MoUs</p>
                    <p class="text-xs text-slate-500">Manage partnerships</p>
                </div>
            </a>
            <a href="<?php echo BASE_URL; ?>/admin/announcements.php?action=new" class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-purple-50 hover:border-purple-200 transition-all group">
                <div class="w-12 h-12 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-500 group-hover:text-purple-600 group-hover:border-purple-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </div>
                <div>
                    <p class="font-bold text-slate-900 text-sm">New Announcement</p>
                    <p class="text-xs text-slate-500">Post urgent news</p>
                </div>
            </a>
            <a href="<?php echo BASE_URL; ?>/admin/contacts.php" class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-orange-50 hover:border-orange-200 transition-all group">
                <div class="w-12 h-12 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-500 group-hover:text-orange-600 group-hover:border-orange-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                </div>
                <div>
                    <p class="font-bold text-slate-900 text-sm">Read Messages</p>
                    <p class="text-xs text-slate-500">View public inquiries</p>
                </div>
            </a>
        </div>
    </div>
    <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-8 text-white flex flex-col justify-between shadow-lg shadow-slate-900/20">
        <div>
            <h3 class="text-lg font-bold mb-2">Secure Portal</h3>
            <p class="text-slate-400 text-sm leading-relaxed">You are currently logged in as <strong><?php echo sanitize($_SESSION['admin_username']); ?></strong>. Remember to logout after finishing your work to keep the portal secure.</p>
        </div>
        <div class="mt-6">
            <a href="<?php echo BASE_URL; ?>/admin/logout.php" class="inline-flex items-center gap-2 text-sm font-bold text-red-400 hover:text-red-300 transition-colors">
                Logout Now
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
            </a>
        </div>
    </div>
</div>


<div class="mt-8 bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
    <h2 class="text-xl font-bold text-slate-900 mb-4">Quick Start Guide</h2>
    <div class="grid md:grid-cols-2 gap-8 text-slate-600">
        <div>
            <h3 class="font-semibold text-slate-900 mb-2">1. Homepage Customization</h3>
            <p class="text-sm mb-4">Update the main slideshow images and captions from the <strong>Slideshow</strong> tab. Global urgent news can be added via the <strong>Announcements</strong> tab.</p>
            <h3 class="font-semibold text-slate-900 mb-2">2. Dean Directory</h3>
            <p class="text-sm">Manage the historical list of Deans in the <strong>Deans</strong> section. You can sort them chronologically using the Display Order field.</p>
        </div>
        <div>
            <h3 class="font-semibold text-slate-900 mb-2">3. Team & Publications</h3>
            <p class="text-sm mb-4">Keep your active staff list up to date in the <strong>Team</strong> tab. Published resources and books can be added through the <strong>Publications</strong> tab.</p>
            <h3 class="font-semibold text-slate-900 mb-2">4. Support & Feedback</h3>
            <p class="text-sm">Monitor public inquiries sent from the Contact Us page via the <strong>Contacts</strong> tab.</p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
