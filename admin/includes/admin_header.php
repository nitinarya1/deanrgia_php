<?php
// Admin header with sidebar layout
$adminLinks = [
    ['name' => 'Dashboard', 'href' => BASE_URL . '/admin/', 'file' => 'index.php', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
    ['name' => 'Announcements', 'href' => BASE_URL . '/admin/announcements.php', 'file' => 'announcements.php', 'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
    ['name' => 'Slideshow', 'href' => BASE_URL . '/admin/slideshow.php', 'file' => 'slideshow.php', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
    ['name' => 'Deans', 'href' => BASE_URL . '/admin/deans.php', 'file' => 'deans.php', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
    ['name' => 'Team', 'href' => BASE_URL . '/admin/team.php', 'file' => 'team.php', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
    ['name' => 'Publications', 'href' => BASE_URL . '/admin/publications.php', 'file' => 'publications.php', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
    ['name' => 'MoU', 'href' => BASE_URL . '/admin/mou.php', 'file' => 'mou.php', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
    ['name' => 'Souvenir', 'href' => BASE_URL . '/admin/souvenir.php', 'file' => 'souvenir.php', 'icon' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4'],
    ['name' => 'Contacts', 'href' => BASE_URL . '/admin/contacts.php', 'file' => 'contacts.php', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
    ['name' => 'Password', 'href' => BASE_URL . '/admin/change_password.php', 'file' => 'change_password.php', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
];

$currentAdminPage = basename($_SERVER['SCRIPT_NAME']);
$currentPageName = 'Dashboard';
foreach ($adminLinks as $l) {
    if ($l['file'] === $currentAdminPage) {
        $currentPageName = $l['name'];
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $currentPageName; ?> - RGIA Admin</title>
    <link rel="icon" type="image/jpeg" href="<?php echo BASE_URL; ?>/public/mnnitlogo.jpg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] } } } }</script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
</head>

<body class="font-sans antialiased">
    <div class="flex h-screen bg-slate-50 overflow-hidden relative">
        <!-- Sidebar -->
        <aside id="admin-sidebar"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 shadow-xl flex flex-col transition-transform duration-300 ease-in-out lg:relative lg:shadow-sm lg:translate-x-0 shrink-0 -translate-x-full">
            <div class="h-20 flex items-center px-6 border-b border-slate-200 shrink-0">
                <a href="<?php echo BASE_URL; ?>/" class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-teal-50 flex items-center justify-center border border-teal-100">
                        <span class="text-teal-600 font-bold">R</span></div>
                    <span class="text-slate-900 font-bold tracking-wide">RGIA Admin</span>
                </a>
            </div>
            <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <?php foreach ($adminLinks as $link): ?>
                    <?php $isActive = ($link['file'] === $currentAdminPage); ?>
                    <a href="<?php echo $link['href']; ?>" onclick="closeSidebar()"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all <?php echo $isActive ? 'admin-link-active' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'; ?>">
                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="<?php echo $link['icon']; ?>" />
                        </svg>
                        <?php echo $link['name']; ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="p-4 border-t border-slate-200 shrink-0">
                <a href="<?php echo BASE_URL; ?>/admin/logout.php"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </a>
            </div>
        </aside>
        <!-- Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden hidden"
            onclick="closeSidebar()"></div>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto w-full relative">
            <header
                class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-10 flex items-center px-4 lg:px-8 justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <button onclick="openSidebar()"
                        class="p-2 -ml-2 rounded-lg text-slate-500 hover:bg-slate-100 lg:hidden">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="text-lg lg:text-xl font-bold text-slate-900"><?php echo $currentPageName; ?></h2>
                </div>
                <div class="flex items-center gap-4">
                    <span
                        class="bg-teal-50 text-teal-700 text-xs font-bold px-3 py-1.5 rounded-full border border-teal-100">Admin
                        Session Active</span>
                </div>
            </header>
            <div class="p-4 sm:p-6 lg:p-8 pb-32">