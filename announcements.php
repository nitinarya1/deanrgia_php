<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'All Announcements';
$db = getDB();
$announcements = $db->query("SELECT * FROM announcements WHERE is_active = 1 ORDER BY date DESC")->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<div class="min-h-screen bg-slate-50">
    <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-3">
            <div class="w-1.5 h-5 bg-red-500 rounded-full"></div>
            <h1 class="text-lg font-bold text-slate-900">All Announcements</h1>
            <span class="text-slate-400 text-sm hidden sm:inline">— Latest news, events, and notices from Dean RGIA</span>
        </div>
    </div>
    <section class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search & Filter -->
            <div class="flex flex-col sm:flex-row gap-3 mb-8">
                <div class="relative flex-1">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <input type="text" id="ann-search" placeholder="Search announcements..." class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/50 shadow-sm">
                </div>
                <select id="ann-year-filter" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/50 shadow-sm">
                    <option value="all">All Years</option>
                    <?php
                    $years = [];
                    foreach ($announcements as $a) {
                        $y = date('Y', strtotime($a['date']));
                        if (!in_array($y, $years)) $years[] = $y;
                    }
                    rsort($years);
                    foreach ($years as $y): ?>
                        <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <p id="ann-count" class="text-slate-500 text-xs mb-4 font-medium"></p>
            <div id="ann-list" class="space-y-6">
                <?php foreach ($announcements as $index => $ann): ?>
                    <?php $url = !empty($ann['link']) ? formatUrl($ann['link']) : ''; ?>
                    <div class="ann-item bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8 hover:shadow-md transition-shadow relative overflow-hidden animate-fade-in-up <?php echo ($url && $url !== '#') ? 'cursor-pointer hover:border-teal-300' : ''; ?>"
                         data-title="<?php echo strtolower(sanitize($ann['title'])); ?>"
                         data-content="<?php echo strtolower(sanitize($ann['content'] ?? '')); ?>"
                         data-year="<?php echo date('Y', strtotime($ann['date'])); ?>"
                         data-url="<?php echo sanitize($url); ?>"
                         style="animation-delay: <?php echo $index * 0.05; ?>s"
                         <?php if ($url && $url !== '#'): ?>onclick="window.open('<?php echo sanitize($url); ?>', '_blank', 'noopener,noreferrer')"<?php endif; ?>>
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-teal-500"></div>
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-sm font-semibold tracking-wide text-teal-600 uppercase"><?php echo formatDate($ann['date']); ?></span>
                                    <?php if ($ann['is_new']): ?>
                                        <span class="bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase animate-pulse">New</span>
                                    <?php endif; ?>
                                </div>
                                <h2 class="text-xl md:text-2xl font-bold text-slate-900 mb-3"><?php echo sanitize($ann['title']); ?></h2>
                                <?php if (!empty($ann['content'])): ?>
                                    <p class="text-slate-600 leading-relaxed mb-5"><?php echo sanitize($ann['content']); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php if ($url && $url !== '#'): ?>
                                <div class="shrink-0 pt-1">
                                    <span class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-slate-900 text-white text-sm font-medium rounded-xl hover:bg-teal-700 transition-colors shadow-sm">
                                        Open Link
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (empty($announcements)): ?>
                <div class="text-center py-24 glass-card rounded-2xl"><p class="text-slate-500 text-lg">No announcements found at this time.</p></div>
            <?php endif; ?>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const search = document.getElementById('ann-search');
    const yearFilter = document.getElementById('ann-year-filter');
    const items = document.querySelectorAll('.ann-item');
    const countEl = document.getElementById('ann-count');

    function filterItems() {
        const q = search.value.toLowerCase().trim();
        const year = yearFilter.value;
        let visible = 0;
        items.forEach(function(item) {
            const title = item.dataset.title;
            const content = item.dataset.content;
            const itemYear = item.dataset.year;
            let show = true;
            if (q && !title.includes(q) && !content.includes(q)) show = false;
            if (year !== 'all' && itemYear !== year) show = false;
            item.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        countEl.textContent = 'Showing ' + visible + ' of ' + items.length + ' announcements' + (q ? ' matching "' + q + '"' : '');
    }
    search.addEventListener('input', filterItems);
    yearFilter.addEventListener('change', filterItems);
    filterItems();
});
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
