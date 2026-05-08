<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Souvenirs';
$db = getDB();
$souvenirs = $db->query("SELECT * FROM souvenirs ORDER BY year DESC")->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<div class="min-h-screen bg-slate-50">
    <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-3">
            <div class="w-1.5 h-5 bg-purple-500 rounded-full"></div>
            <h1 class="text-lg font-bold text-slate-900">Souvenirs</h1>
            <span class="text-slate-400 text-sm hidden sm:inline">— Convocation and Global Alumni Meet souvenirs</span>
        </div>
    </div>
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Tabs -->
            <div class="flex justify-center mb-12">
                <div class="inline-flex bg-slate-200/60 p-1.5 rounded-xl">
                    <button onclick="filterSouvenirs('Convocation')" id="tab-convocation" class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-all bg-white text-teal-700 shadow-sm">Convocation Souvenir</button>
                    <button onclick="filterSouvenirs('Alumni')" id="tab-alumni" class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-all text-slate-500 hover:text-slate-800">Alumni Souvenir</button>
                </div>
            </div>
            <?php if (empty($souvenirs)): ?>
                <div class="text-center py-24 glass-card"><p class="text-slate-500 text-lg">No souvenirs available.</p></div>
            <?php else: ?>
            <div id="souvenirs-grid" class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($souvenirs as $index => $item): ?>
                <div class="souvenir-item glass-card p-8 flex flex-col group hover:-translate-y-2 transition-all animate-fade-in-up border border-slate-200"
                     data-category="<?php echo sanitize($item['category']); ?>"
                     style="animation-delay: <?php echo $index * 0.1; ?>s">
                    <div class="souvenir-icon w-16 h-16 mb-6 rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110 <?php echo $item['category'] === 'Alumni' ? 'bg-purple-50 text-purple-600' : 'bg-teal-50 text-teal-600'; ?>">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <div class="mb-4">
                        <span class="souvenir-year-badge text-xs font-bold px-2.5 py-1 rounded-md mb-3 inline-block <?php echo $item['category'] === 'Alumni' ? 'bg-purple-100 text-purple-800' : 'bg-teal-100 text-teal-800'; ?>"><?php echo $item['year']; ?></span>
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-teal-700 transition-colors"><?php echo sanitize($item['title']); ?></h3>
                    </div>
                    <p class="text-slate-600 text-sm mb-8 flex-1"><?php echo sanitize($item['description']); ?></p>
                    <div class="flex gap-3 mt-auto">
                        <button onclick="openPdfViewer('<?php echo sanitize($item['pdf_link'] ?: '#'); ?>')" class="souvenir-view-btn flex-1 py-2.5 rounded-xl text-sm font-medium transition-colors text-center <?php echo $item['category'] === 'Alumni' ? 'bg-purple-600 hover:bg-purple-700 text-white' : 'bg-teal-600 hover:bg-teal-700 text-white'; ?>">View</button>
                        <a href="<?php echo sanitize($item['pdf_link'] ?: '#'); ?>" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-medium transition-colors flex items-center justify-center border border-slate-200" title="Download PDF">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- PDF Viewer Modal -->
    <div id="pdf-modal" class="fixed inset-0 z-[100] bg-slate-900/90 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6 lg:p-8 animate-fade-in hidden">
        <div class="bg-white rounded-2xl w-full max-w-6xl h-full max-h-[90vh] flex flex-col shadow-2xl overflow-hidden border border-slate-200">
            <div class="flex justify-between items-center p-4 border-b border-slate-200 bg-slate-50">
                <h3 class="font-bold text-slate-900">Souvenir Viewer</h3>
                <button onclick="closePdfViewer()" class="text-slate-500 hover:text-slate-900 p-2 hover:bg-slate-200 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="flex-1 w-full bg-slate-200 relative" id="pdf-content"></div>
        </div>
    </div>
</div>

<script>
var activeTab = 'Convocation';

function filterSouvenirs(category) {
    activeTab = category;
    var items = document.querySelectorAll('.souvenir-item');
    var tabConv = document.getElementById('tab-convocation');
    var tabAlumni = document.getElementById('tab-alumni');
    var hasVisible = false;

    items.forEach(function(item) {
        if (item.dataset.category === category) {
            item.style.display = '';
            hasVisible = true;
        } else {
            item.style.display = 'none';
        }
    });

    if (category === 'Convocation') {
        tabConv.className = 'px-6 py-2.5 rounded-lg text-sm font-semibold transition-all bg-white text-teal-700 shadow-sm';
        tabAlumni.className = 'px-6 py-2.5 rounded-lg text-sm font-semibold transition-all text-slate-500 hover:text-slate-800';
    } else {
        tabAlumni.className = 'px-6 py-2.5 rounded-lg text-sm font-semibold transition-all bg-white text-purple-700 shadow-sm';
        tabConv.className = 'px-6 py-2.5 rounded-lg text-sm font-semibold transition-all text-slate-500 hover:text-slate-800';
    }
}

function openPdfViewer(url) {
    var modal = document.getElementById('pdf-modal');
    var content = document.getElementById('pdf-content');
    if (url === '#') {
        content.innerHTML = '<div class="absolute inset-0 flex flex-col items-center justify-center text-slate-500"><svg class="w-16 h-16 mb-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><p class="text-lg font-medium text-slate-600">PDF not available</p><p class="text-sm">The document link for this souvenir is currently empty.</p></div>';
    } else {
        content.innerHTML = '<iframe src="' + url + '#toolbar=0" class="w-full h-full border-none" title="PDF Viewer"></iframe>';
    }
    modal.classList.remove('hidden');
}

function closePdfViewer() {
    document.getElementById('pdf-modal').classList.add('hidden');
    document.getElementById('pdf-content').innerHTML = '';
}

document.addEventListener('DOMContentLoaded', function() { filterSouvenirs('Convocation'); });
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
