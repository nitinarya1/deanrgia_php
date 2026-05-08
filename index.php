<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$db = getDB();

// Fetch slides
$slides = $db->query("SELECT * FROM slideshows WHERE is_active = 1 ORDER BY display_order ASC")->fetchAll();

// Fetch announcements (active, newest first, limit 10)
$announcements = $db->query("SELECT * FROM announcements WHERE is_active = 1 ORDER BY date DESC LIMIT 10")->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<div class="min-h-screen bg-slate-50">

    <!-- ========== Slideshow LEFT + Announcements RIGHT ========== -->
    <section class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid lg:grid-cols-5 gap-6">

                <!-- LEFT: Slideshow -->
                <div class="lg:col-span-3 relative rounded-xl overflow-hidden bg-slate-900 aspect-[16/10] slideshow-container group">
                    <?php if (count($slides) > 0): ?>
                        <?php foreach ($slides as $i => $slide): ?>
                            <div class="slideshow-slide <?php echo $i === 0 ? 'active' : 'inactive'; ?>">
                                <img
                                    src="<?php echo imageUrl($slide['image_url']); ?>"
                                    alt="<?php echo sanitize($slide['caption'] ?: 'MNNIT RGIA'); ?>"
                                    class="w-full h-full object-cover"
                                >
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                    <p class="text-white font-semibold text-sm md:text-base drop-shadow">
                                        <?php echo sanitize($slide['caption'] ?: 'Resource Generation & International Affairs'); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php if (count($slides) > 1): ?>
                            <!-- Left/Right Arrows -->
                            <button onclick="slideshowPrev()" class="slideshow-arrow absolute left-2 top-1/2 -translate-y-1/2 z-20 w-9 h-9 bg-white/80 hover:bg-white rounded-full flex items-center justify-center shadow-md transition-all" aria-label="Previous slide">
                                <svg class="w-5 h-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                            </button>
                            <button onclick="slideshowNext()" class="slideshow-arrow absolute right-2 top-1/2 -translate-y-1/2 z-20 w-9 h-9 bg-white/80 hover:bg-white rounded-full flex items-center justify-center shadow-md transition-all" aria-label="Next slide">
                                <svg class="w-5 h-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </button>

                            <!-- Dot indicators -->
                            <div class="absolute bottom-14 left-1/2 -translate-x-1/2 z-20 flex gap-1.5">
                                <?php foreach ($slides as $i => $s): ?>
                                    <button onclick="slideshowGoto(<?php echo $i; ?>)" class="slideshow-dot h-1.5 rounded-full transition-all <?php echo $i === 0 ? 'w-6 bg-white' : 'w-1.5 bg-white/50'; ?>"></button>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="w-full h-full flex flex-col items-center justify-center bg-slate-100 p-6 text-center">
                            <div class="w-10 h-10 border-4 border-teal-200 border-t-teal-600 rounded-full animate-spin mb-5"></div>
                            <h3 class="text-slate-700 font-bold tracking-wide text-sm md:text-base">
                                Motilal Nehru National Institute of Technology Allahabad
                            </h3>
                            <p class="text-slate-500 text-xs md:text-sm mt-1 uppercase tracking-widest font-semibold">
                                Resource Generation & International Affairs
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- RIGHT: Announcements -->
                <div class="lg:col-span-2 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <span class="text-red-500 text-xs animate-pulse">●</span>
                            ANNOUNCEMENTS
                        </h2>
                        <a href="<?php echo BASE_URL; ?>/announcements.php" class="text-xs text-teal-600 hover:text-teal-800 font-semibold flex items-center gap-1 transition-colors">
                            View All
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    </div>

                    <div class="flex-1 border border-slate-200 rounded-xl overflow-hidden bg-white">
                        <div class="divide-y divide-slate-100 max-h-[400px] overflow-y-auto">
                            <?php if (empty($announcements)): ?>
                                <div class="p-8 text-center text-slate-400 text-sm">No announcements yet.</div>
                            <?php else: ?>
                                <?php foreach ($announcements as $ann): ?>
                                    <div class="px-4 py-3 hover:bg-slate-50 transition-colors">
                                        <?php $url = !empty($ann['link']) ? formatUrl($ann['link']) : ''; ?>
                                        <?php if ($url && $url !== '#'): ?>
                                            <a href="<?php echo sanitize($url); ?>" target="_blank" rel="noopener noreferrer" class="text-slate-800 hover:text-teal-700 text-sm leading-relaxed transition-colors block group">
                                                <span class="group-hover:underline"><?php echo sanitize($ann['title']); ?></span>
                                                <?php if ($ann['is_new']): ?>
                                                    <span class="ml-2 inline-block bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded uppercase animate-pulse align-middle">New</span>
                                                <?php endif; ?>
                                                <span class="block text-slate-400 text-xs mt-0.5"><?php echo formatDate($ann['date']); ?></span>
                                            </a>
                                        <?php else: ?>
                                            <div class="text-slate-800 text-sm leading-relaxed">
                                                <?php echo sanitize($ann['title']); ?>
                                                <?php if ($ann['is_new']): ?>
                                                    <span class="ml-2 inline-block bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded uppercase animate-pulse align-middle">New</span>
                                                <?php endif; ?>
                                                <span class="block text-slate-400 text-xs mt-0.5"><?php echo formatDate($ann['date']); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========== Quick Links ========== -->
    <section class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">

                <a href="<?php echo BASE_URL; ?>/dean-rgia.php" class="bg-white rounded-xl p-5 border border-slate-200 hover:border-teal-300 hover:shadow-md transition-all group">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-teal-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 group-hover:text-teal-700 transition-colors">Dean RGIA</h3>
                    </div>
                    <p class="text-slate-500 text-xs">Past and present Deans of RGIA</p>
                </a>

                <a href="<?php echo BASE_URL; ?>/publications.php" class="bg-white rounded-xl p-5 border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 group-hover:text-blue-700 transition-colors">Publications</h3>
                    </div>
                    <p class="text-slate-500 text-xs">Books and research by our faculty</p>
                </a>

                <a href="<?php echo BASE_URL; ?>/souvenir.php" class="bg-white rounded-xl p-5 border border-slate-200 hover:border-purple-300 hover:shadow-md transition-all group">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 group-hover:text-purple-700 transition-colors">Souvenirs</h3>
                    </div>
                    <p class="text-slate-500 text-xs">Convocation and Alumni Meet souvenirs</p>
                </a>

                <a href="<?php echo BASE_URL; ?>/contact.php" class="bg-white rounded-xl p-5 border border-slate-200 hover:border-amber-300 hover:shadow-md transition-all group">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 group-hover:text-amber-700 transition-colors">Contact Us</h3>
                    </div>
                    <p class="text-slate-500 text-xs">Get in touch with RGIA office</p>
                </a>

            </div>
        </div>
    </section>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
