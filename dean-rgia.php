<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Dean RGIA Directory';
$db = getDB();
$deans = $db->query("SELECT * FROM deans ORDER BY display_order ASC")->fetchAll();

// Find current dean (tenure contains 'Present')
$currentDean = null;
$pastDeans = [];
foreach ($deans as $d) {
    if (stripos($d['tenure'], 'present') !== false) {
        $currentDean = $d;
    } else {
        $pastDeans[] = $d;
    }
}
if (!$currentDean && !empty($deans)) $currentDean = end($deans);
$pastDeans = array_filter($deans, function($d) use ($currentDean) { return $d['id'] !== ($currentDean['id'] ?? -1); });
$pastDeans = array_reverse($pastDeans);

include __DIR__ . '/includes/header.php';
?>
<div class="min-h-screen bg-slate-50">
    <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-3">
            <div class="w-1.5 h-5 bg-teal-500 rounded-full"></div>
            <h1 class="text-lg font-bold text-slate-900">Dean RGIA Directory</h1>
            <span class="text-slate-400 text-sm hidden sm:inline">— Honoring the leadership and vision of our past and present Deans</span>
        </div>
    </div>
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php if (empty($deans)): ?>
                <div class="text-center py-24 glass-card"><p class="text-slate-500 text-lg">No dean records found.</p></div>
            <?php else: ?>
                <!-- Current Dean -->
                <?php if ($currentDean): ?>
                <div class="mb-24">
                    <div class="text-center mb-12 animate-fade-in-up">
                        <h2 class="text-3xl border-b-4 border-teal-500 inline-block pb-3 font-extrabold text-slate-900 tracking-tight">Current Dean, RGIA</h2>
                    </div>
                    <div class="max-w-4xl mx-auto">
                        <div class="bg-white rounded-3xl overflow-hidden group hover:-translate-y-2 transition-all duration-500 animate-fade-in-up flex flex-col md:flex-row items-center relative border border-slate-200 shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] hover:shadow-[0_30px_60px_-15px_rgba(20,184,166,0.2)]">
                            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-teal-400 via-emerald-500 to-teal-500 md:hidden"></div>
                            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-teal-400 via-emerald-500 to-teal-500 hidden md:block"></div>
                            <div class="p-10 md:w-2/5 flex justify-center bg-slate-50/50 w-full md:h-full items-center">
                                <div class="w-56 h-56 rounded-full overflow-hidden border-8 border-white shadow-2xl bg-amber-50 group-hover:scale-105 transition-transform duration-500 relative ring-4 ring-teal-100/50">
                                    <img src="<?php echo imageUrl($currentDean['image']); ?>" alt="<?php echo sanitize($currentDean['name']); ?>" class="w-full h-full object-cover" onerror="this.src='<?php echo BASE_URL; ?>/public/placeholder-professor.svg'">
                                </div>
                            </div>
                            <div class="p-8 md:p-12 md:w-3/5 flex flex-col text-center md:text-left flex-1 relative bg-white">
                                <p class="text-teal-600 font-bold tracking-wider text-sm mb-3 uppercase flex items-center justify-center md:justify-start gap-2">
                                    <span class="w-8 h-px bg-teal-600 hidden md:inline-block"></span>
                                    <?php echo sanitize($currentDean['designation']); ?>
                                </p>
                                <h3 class="text-4xl font-black text-slate-900 mb-6 group-hover:text-teal-700 transition-colors tracking-tight"><?php echo sanitize($currentDean['name']); ?></h3>
                                <div class="space-y-4 mb-8">
                                    <p class="text-slate-600 text-lg leading-relaxed line-clamp-3 font-medium"><?php echo sanitize($currentDean['bio'] ?: 'Leading the Resource Generation and International Affairs initiatives at MNNIT Allahabad.'); ?></p>
                                </div>
                                <div class="mt-auto pt-6 border-t border-slate-100 w-full flex flex-wrap gap-4 justify-center md:justify-start">
                                    <div class="flex items-center gap-3 bg-slate-50 px-5 py-3 rounded-xl border border-slate-100">
                                        <div class="w-10 h-10 rounded-full bg-teal-100/50 flex items-center justify-center text-teal-600">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-0.5">Tenure</p>
                                            <p class="text-slate-800 font-bold"><?php echo sanitize($currentDean['tenure']); ?></p>
                                        </div>
                                    </div>
                                    <?php if (!empty($currentDean['email'])): ?>
                                    <div class="flex items-center gap-3 bg-slate-50 px-5 py-3 rounded-xl border border-slate-100">
                                        <div class="w-10 h-10 rounded-full bg-blue-100/50 flex items-center justify-center text-blue-600">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-0.5">Contact</p>
                                            <p class="text-slate-800 font-bold"><?php echo sanitize($currentDean['email']); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($currentDean['profile_link'])): ?>
                                    <div class="w-full mt-2">
                                        <a href="<?php echo formatUrl($currentDean['profile_link']); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-teal-700 transition-colors shadow-sm">
                                            View Complete Profile
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                        </a>
                                    </div>
                                    <?php else: ?>
                                    <div class="w-full mt-2">
                                        <span class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-slate-200 text-slate-500 text-sm font-semibold cursor-default">View Complete Profile <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Past Deans -->
                <?php if (!empty($pastDeans)): ?>
                <div class="mt-16 sm:mt-24">
                    <div class="text-center mb-12 animate-fade-in-up">
                        <h2 class="text-3xl border-b-4 border-slate-200 inline-block pb-3 font-extrabold text-slate-800 tracking-tight">Past Deans</h2>
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 xl:gap-10">
                        <?php foreach ($pastDeans as $index => $dean): ?>
                        <div class="glass-card overflow-hidden group hover:-translate-y-2 transition-all duration-300 animate-fade-in-up flex flex-col border border-slate-200 hover:border-slate-300 shadow-sm hover:shadow-xl" style="animation-delay: <?php echo $index * 0.1; ?>s">
                            <div class="h-2 bg-gradient-to-r from-slate-300 to-slate-400 group-hover:from-teal-400 group-hover:to-emerald-400 transition-all duration-500"></div>
                            <div class="p-8 flex flex-col items-center text-center flex-1 bg-white">
                                <div class="w-36 h-36 rounded-full overflow-hidden mb-6 border-4 border-white shadow-md bg-slate-50 group-hover:scale-105 transition-transform duration-500 relative group-hover:shadow-xl">
                                    <img src="<?php echo imageUrl($dean['image']); ?>" alt="<?php echo sanitize($dean['name']); ?>" class="w-full h-full object-cover grayscale-[20%] group-hover:grayscale-0 transition-all duration-500" onerror="this.src='<?php echo BASE_URL; ?>/public/placeholder-professor.svg'">
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 mb-1 group-hover:text-teal-700 transition-colors"><?php echo sanitize($dean['name']); ?></h3>
                                <p class="text-slate-500 font-medium text-sm mb-4 uppercase tracking-wide group-hover:text-teal-600 transition-colors"><?php echo sanitize($dean['designation']); ?></p>
                                <div class="mt-auto pt-5 border-t border-slate-100 w-full flex flex-col items-center">
                                    <p class="text-slate-600 text-sm font-semibold flex items-center justify-center gap-2 mb-3">
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-teal-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        <?php echo sanitize($dean['tenure']); ?>
                                    </p>
                                    <?php if (!empty($dean['profile_link'])): ?>
                                    <a href="<?php echo formatUrl($dean['profile_link']); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-slate-100 text-slate-700 text-xs font-bold hover:bg-teal-600 hover:text-white transition-colors border border-slate-200 hover:border-teal-600 w-fit mx-auto">
                                        View Complete Profile <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                    </a>
                                    <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-slate-100 text-slate-400 text-xs font-bold border border-slate-200 w-fit mx-auto cursor-default">
                                        View Complete Profile <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
