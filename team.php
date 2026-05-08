<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Our Team';
$db = getDB();
$teamMembers = $db->query("SELECT * FROM team ORDER BY id ASC")->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<div class="min-h-screen bg-slate-50">
    <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-3">
            <div class="w-1.5 h-5 bg-teal-500 rounded-full"></div>
            <h1 class="text-lg font-bold text-slate-900">Our Team</h1>
            <span class="text-slate-400 text-sm hidden sm:inline">— The dedicated professionals leading RGIA initiatives</span>
        </div>
    </div>
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php if (empty($teamMembers)): ?>
                <div class="text-center py-24 glass-card"><p class="text-slate-500 text-lg">No team members found.</p></div>
            <?php else: ?>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($teamMembers as $index => $member): ?>
                <div class="glass-card overflow-hidden group hover:-translate-y-2 transition-all animate-fade-in-up" style="animation-delay: <?php echo $index * 0.1; ?>s">
                    <div class="h-2 bg-gradient-to-r from-teal-400 to-blue-500"></div>
                    <div class="p-8 flex flex-col items-center text-center">
                        <div class="w-28 h-28 md:w-32 md:h-32 rounded-full overflow-hidden mb-6 shadow-xl border-4 border-white bg-slate-100 relative group-hover:scale-105 transition-transform duration-500">
                            <img src="<?php echo imageUrl($member['image']); ?>" alt="<?php echo sanitize($member['name']); ?>" class="w-full h-full object-cover" onerror="this.src='<?php echo BASE_URL; ?>/public/placeholder-professor.svg'">
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-slate-900 mb-1 group-hover:text-teal-700 transition-colors"><?php echo sanitize($member['name']); ?></h3>
                        <p class="text-teal-600 font-medium text-sm mb-3"><?php echo sanitize($member['role']); ?></p>
                        <div class="w-full pt-4 border-t border-slate-100 mt-2 flex flex-col items-center">
                            <p class="text-slate-500 text-xs uppercase tracking-wider font-semibold mb-3"><?php echo sanitize($member['department']); ?></p>
                            <?php if (!empty($member['profile_link'])): ?>
                            <a href="<?php echo formatUrl($member['profile_link']); ?>" target="_blank" rel="noopener noreferrer" class="px-4 py-1.5 rounded-full bg-teal-50 text-teal-700 text-xs font-bold hover:bg-teal-600 hover:text-white transition-colors border border-teal-200 hover:border-teal-600 flex items-center gap-1">
                                View Complete Profile <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </a>
                            <?php else: ?>
                            <span class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-400 text-xs font-bold border border-slate-200 flex items-center gap-1 cursor-default">
                                View Complete Profile <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
