<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Publications';
$db = getDB();
$publications = $db->query("SELECT * FROM publications ORDER BY created_at DESC")->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<div class="min-h-screen bg-slate-50">
    <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-3">
            <div class="w-1.5 h-5 bg-blue-500 rounded-full"></div>
            <h1 class="text-lg font-bold text-slate-900">Publications</h1>
            <span class="text-slate-400 text-sm hidden sm:inline">— Books authored by our distinguished alumni and faculty</span>
        </div>
    </div>
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="relative max-w-lg">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <input type="text" id="pub-search" placeholder="Search by title, author, or keyword..." class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 shadow-sm">
                </div>
            </div>
            <p id="pub-count" class="text-slate-500 text-xs mb-4 font-medium"></p>
            <?php if (empty($publications)): ?>
                <div class="text-center py-24 glass-card"><p class="text-slate-500 text-lg">No publications found.</p></div>
            <?php else: ?>
            <div id="pub-list" class="space-y-8">
                <?php foreach ($publications as $index => $pub): ?>
                <div class="pub-item glass-card p-8 md:p-10 flex flex-col md:flex-row gap-8 items-start animate-fade-in-up group relative overflow-hidden"
                     data-title="<?php echo strtolower(sanitize($pub['title'])); ?>"
                     data-author="<?php echo strtolower(sanitize($pub['author'])); ?>"
                     data-description="<?php echo strtolower(sanitize($pub['description'] ?? '')); ?>"
                     style="animation-delay: <?php echo $index * 0.05; ?>s">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-full md:w-36 h-48 md:h-52 rounded-xl bg-slate-100 flex items-center justify-center shrink-0 border border-slate-200 overflow-hidden shadow-sm group-hover:shadow-md transition-shadow">
                        <?php if (!empty($pub['image'])): ?>
                            <img src="<?php echo imageUrl($pub['image']); ?>" alt="<?php echo sanitize($pub['title']); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="text-center p-4">
                                <div class="w-12 h-12 mx-auto mb-2 rounded-xl bg-blue-50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                </div>
                                <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">Book Info</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start gap-3 mb-4">
                            <span class="text-xs font-bold text-blue-700 bg-blue-50 px-3 py-1.5 rounded-lg uppercase tracking-widest shrink-0 border border-blue-100">Book</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3 group-hover:text-blue-700 transition-colors"><?php echo sanitize($pub['title']); ?></h3>
                        <?php if (!empty($pub['link'])): ?>
                            <a href="<?php echo formatUrl($pub['link']); ?>" target="_blank" rel="noreferrer" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 font-medium text-sm mb-4 transition-colors bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg border border-blue-100">
                                Read / View Book
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </a>
                        <?php endif; ?>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center overflow-hidden">
                                <img src="<?php echo BASE_URL; ?>/public/placeholder-professor.svg" alt="<?php echo sanitize($pub['author']); ?>" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-slate-900 text-sm font-medium"><?php echo sanitize($pub['author']); ?></p>
                                <p class="text-slate-500 text-xs">Author</p>
                            </div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed"><?php echo sanitize($pub['description']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var search = document.getElementById('pub-search');
    var items = document.querySelectorAll('.pub-item');
    var countEl = document.getElementById('pub-count');
    function filter() {
        var q = search.value.toLowerCase().trim();
        var visible = 0;
        items.forEach(function(item) {
            var show = !q || item.dataset.title.includes(q) || item.dataset.author.includes(q) || item.dataset.description.includes(q);
            item.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        countEl.textContent = visible + ' publication' + (visible !== 1 ? 's' : '') + ' found' + (q ? ' matching "' + q + '"' : '');
    }
    search.addEventListener('input', filter);
    filter();
});
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
