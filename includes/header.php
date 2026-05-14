<?php
/**
 * Shared Header - Dean RGIA MNNIT
 * Clean, single-tier sticky navbar — no flickering
 */
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/functions.php';
}

$navLinks = getNavLinks();
$currentPage = getCurrentPage();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0d9488">
    <title><?php echo isset($pageTitle) ? sanitize($pageTitle) . ' | ' : ''; ?>RGIA - Resource Generation and
        International Affairs | Motilal Nehru National Institute of Technology Allahabad</title>
    <meta name="description"
        content="<?php echo isset($pageDescription) ? sanitize($pageDescription) : 'Office of Dean, Resource Generation and International Affairs, Motilal Nehru National Institute of Technology Allahabad, Prayagraj. Fostering Global Partnerships & Resource Mobilization.'; ?>">
    <meta name="keywords"
        content="RGIA, MNNIT, Allahabad, Prayagraj, Resource Generation, International Affairs, NIT, Dean, Publications, Souvenir">
    <meta name="robots" content="index, follow">

    <!-- Open Graph -->
    <meta property="og:title" content="Dean RGIA — Motilal Nehru National Institute of Technology Allahabad">
    <meta property="og:description"
        content="Office of Dean, Resource Generation and International Affairs, Motilal Nehru National Institute of Technology Allahabad.">
    <meta property="og:url" content="https://<?php echo SITE_DOMAIN; ?>">
    <meta property="og:image" content="<?php echo BASE_URL; ?>/public/mnnitlogo.jpg">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_IN">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Dean RGIA — Motilal Nehru National Institute of Technology Allahabad">
    <meta name="twitter:description"
        content="Office of Dean, Resource Generation and International Affairs, Motilal Nehru National Institute of Technology Allahabad.">
    <meta name="twitter:image" content="<?php echo BASE_URL; ?>/public/mnnitlogo.jpg">

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="<?php echo BASE_URL; ?>/public/mnnitlogo.jpg">

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
</head>

<body class="font-sans antialiased min-h-screen flex flex-col bg-slate-50 text-slate-900">

    <!-- ========== NAVBAR ========== -->
    <nav id="main-navbar" class="fixed top-0 left-0 right-0 z-50 navbar-glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-[72px]">

                <!-- Logo -->
                <a href="<?php echo BASE_URL; ?>/" class="flex items-center gap-3 shrink-0">
                    <img src="<?php echo BASE_URL; ?>/public/mnnitlogo.jpg" alt="MNNIT Logo"
                        class="w-10 h-10 lg:w-12 lg:h-12 object-contain shrink-0">
                    <div>
                        <h1 class="text-slate-900 font-extrabold text-sm lg:text-base tracking-wide leading-tight">
                            Dean RGIA
                        </h1>
                        <p class="text-teal-700 text-[10px] lg:text-xs font-semibold leading-tight tracking-wide">
                            Motilal Nehru National Institute of Technology Allahabad
                        </p>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-1">
                    <?php foreach ($navLinks as $link): ?>
                        <?php $isActive = isActivePage($link['href']); ?>
                        <a href="<?php echo $link['href']; ?>" class="nav-link px-3 xl:px-4 py-2 rounded-lg text-[13px] font-semibold
                            <?php echo $isActive
                                ? 'nav-link-active'
                                : ''; ?>">
                            <?php echo sanitize($link['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- Admin Login Button - Desktop -->
                <div class="hidden lg:flex items-center">
                    <a href="<?php echo BASE_URL; ?>/admin/login.php"
                        class="px-4 py-2 rounded-lg text-xs font-bold bg-teal-600 text-white hover:bg-teal-700 transition-colors">
                        Admin
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button id="mobile-menu-btn"
                    class="lg:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100/80 transition-colors"
                    aria-label="Toggle menu">
                    <svg id="menu-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="menu-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Dropdown -->
        <div id="mobile-menu" class="lg:hidden mobile-menu-closed">
            <div class="px-4 pb-4 pt-2 space-y-1 bg-white/95 backdrop-blur-xl border-t border-slate-100">
                <?php foreach ($navLinks as $link): ?>
                    <?php $isActive = isActivePage($link['href']); ?>
                    <a href="<?php echo $link['href']; ?>" class="block px-4 py-3 rounded-lg text-sm font-medium transition-colors
                        <?php echo $isActive
                            ? 'bg-teal-50 text-teal-700'
                            : 'text-slate-600 hover:text-teal-700 hover:bg-slate-50'; ?>">
                        <?php echo sanitize($link['name']); ?>
                    </a>
                <?php endforeach; ?>

                <div class="pt-2 mt-2 border-t border-slate-100">
                    <a href="<?php echo BASE_URL; ?>/admin/login.php"
                        class="block px-4 py-3 rounded-lg text-sm font-bold bg-teal-600 text-white text-center hover:bg-teal-700 transition-colors">
                        Admin Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Spacer to offset fixed navbar -->
    <div class="h-16 lg:h-[72px]"></div>

    <!-- ========== MAIN CONTENT ========== -->
    <main class="flex-1">