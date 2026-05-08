<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Memorandum of Understanding';
$db = getDB();
$mous = $db->query("SELECT * FROM mous ORDER BY date DESC")->fetchAll();
$countries = array_unique(array_filter(array_column($mous, 'country')));
sort($countries);
include __DIR__ . '/includes/header.php';
?>
<div class="min-h-screen bg-slate-50">
    <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-3">
            <div class="w-1.5 h-5 bg-emerald-500 rounded-full"></div>
            <h1 class="text-lg font-bold text-slate-900">Memorandum of Understanding</h1>
            <span class="text-slate-400 text-sm hidden sm:inline">— Global academic partnerships and collaborations</span>
        </div>
    </div>
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row gap-3 mb-8">
                <div class="relative flex-1">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <input type="text" id="mou-search" placeholder="Search by institution, country, or description..." class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/50 shadow-sm">
                </div>
                <select id="mou-country" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/50 shadow-sm">
                    <option value="all">All Countries</option>
                    <?php foreach ($countries as $c): ?>
                        <option value="<?php echo sanitize($c); ?>"><?php echo sanitize($c); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <p id="mou-count" class="text-slate-500 text-xs mb-4 font-medium"></p>
            <?php if (empty($mous)): ?>
                <div class="text-center py-24 glass-card"><p class="text-slate-500 text-lg">No MoUs found.</p></div>
            <?php else: ?>
            <div id="mou-list" class="grid gap-6">
                <?php foreach ($mous as $index => $mou): ?>
                <div class="mou-item glass-card p-6 md:p-8 flex flex-col md:flex-row gap-6 md:items-center justify-between group hover:border-teal-300 transition-colors animate-slide-in-left"
                     data-institution="<?php echo strtolower(sanitize($mou['institution'])); ?>"
                     data-description="<?php echo strtolower(sanitize($mou['description'] ?? '')); ?>"
                     data-country="<?php echo sanitize($mou['country']); ?>"
                     style="animation-delay: <?php echo $index * 0.05; ?>s">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="bg-teal-50 text-teal-700 text-xs font-bold px-2 py-1 rounded-md border border-teal-100"><?php echo sanitize($mou['country']); ?></span>
                            <span class="text-slate-400 text-sm">Valid from: <?php echo formatDate($mou['date']); ?></span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-teal-700 transition-colors mb-2"><?php echo sanitize($mou['institution']); ?></h3>
                        <p class="text-slate-600 text-sm"><?php echo sanitize($mou['description']); ?></p>
                    </div>
                    <div class="shrink-0 flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-slate-700 font-medium text-sm border bg-white border-slate-200 px-3 py-1.5 rounded-full"><?php echo sanitize($mou['status']); ?></span>
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
    var search = document.getElementById('mou-search');
    var countryFilter = document.getElementById('mou-country');
    var items = document.querySelectorAll('.mou-item');
    var countEl = document.getElementById('mou-count');
    function filter() {
        var q = search.value.toLowerCase().trim();
        var country = countryFilter.value;
        var visible = 0;
        items.forEach(function(item) {
            var show = true;
            if (q && !item.dataset.institution.includes(q) && !item.dataset.description.includes(q) && !item.dataset.country.toLowerCase().includes(q)) show = false;
            if (country !== 'all' && item.dataset.country !== country) show = false;
            item.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        countEl.textContent = visible + ' MoU' + (visible !== 1 ? 's' : '') + ' found' + (q ? ' matching "' + q + '"' : '') + (country !== 'all' ? ' in ' + country : '');
    }
    search.addEventListener('input', filter);
    countryFilter.addEventListener('change', filter);
    filter();
});
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
