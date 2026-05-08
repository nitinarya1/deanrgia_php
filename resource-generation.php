<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Resource Generation';
include __DIR__ . '/includes/header.php';

// Static content from siteData.js
$preamble = "India has a great heritage of patronage of education by philanthropists. A number of institutions of higher learning came into existence during the pre-independence period on the initiative of private individuals and voluntary organizations. In order to serve our mission to support higher education, professional education and technological development of society in the development of National Institutes of Technology in the country, it is being emphasized by the Government of India to mobilize financial resources from alumni as well as others. It is increasingly being realized that a large system of higher education has largely been financed and managed by the Government. Wider participation of alumni, citizens and social bodies is imperative for creating a constructive change in the system.";

$objectives = [
    "To enhance international potential of the Institute.",
    "To develop and foster a symbiotic relationship between the Institute and its prospective benefactors and academic institutions worldwide.",
    "To cultivate international linkages by entering into MoUs for academic and research collaboration.",
    "To identify potential sources and the benefactors.",
    "To prepare a framework for effective utilization of funds.",
    "To encourage tangible/in-tangible benefits to the donors.",
];

$resourceInfo = "The Institute invites all the alumni and philanthropists to come forward for the cause of high quality resources for the future generations of students. The industry partners are also invited to participate in campus development through CSR funds for community development activities. The Institute participates in various Government funding schemes like TEQIP, Visiting Research Fund, etc.";
?>
<div class="min-h-screen">
    <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-3">
            <div class="w-1.5 h-5 bg-teal-500 rounded-full"></div>
            <h1 class="text-lg font-bold text-slate-900">Resource Generation</h1>
            <span class="text-slate-400 text-sm hidden sm:inline">— Supporting the growth of MNNIT through resource mobilization</span>
        </div>
    </div>
    <!-- Preamble -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card p-8 md:p-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/20 flex items-center justify-center"><span class="text-teal-600 font-bold">1</span></div>
                    <h2 class="text-2xl font-bold text-slate-900">Preamble</h2>
                </div>
                <p class="text-slate-700 leading-relaxed text-base"><?php echo $preamble; ?></p>
            </div>
        </div>
    </section>
    <!-- Objectives -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm p-8 md:p-10 border border-slate-200">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center"><span class="text-teal-600 font-bold">2</span></div>
                    <h2 class="text-2xl font-bold text-slate-900">Objectives</h2>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <?php foreach ($objectives as $i => $obj): ?>
                    <div class="flex items-start gap-4 p-5 rounded-xl bg-slate-50 border border-slate-200 hover:border-teal-200 transition-colors">
                        <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-teal-500 to-emerald-500 flex items-center justify-center text-white text-xs font-bold shrink-0 shadow-sm"><?php echo chr(105 + $i); ?></span>
                        <p class="text-slate-800 text-sm font-medium leading-relaxed"><?php echo $obj; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Resource Info -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 md:p-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center"><span class="text-teal-600 font-bold">3</span></div>
                    <h2 class="text-2xl font-bold text-slate-900">Resource Generation</h2>
                </div>
                <p class="text-slate-600 leading-relaxed text-base mb-8"><?php echo $resourceInfo; ?></p>
                <div class="bg-gradient-to-br from-teal-50 to-emerald-50 rounded-xl p-6 border border-teal-100">
                    <h3 class="text-lg font-semibold text-teal-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                        Account Details for Donations
                    </h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <?php
                        $details = [
                            ['Account Name', 'MNNIT DONATION FUND'],
                            ['Bank Name', 'State Bank of India'],
                            ['Branch', 'MNNIT Allahabad'],
                            ['Account No.', '00000000000'],
                            ['IFSC Code', 'SBIN000000'],
                        ];
                        foreach ($details as $d): ?>
                        <div class="bg-white/80 rounded-lg p-3 border border-teal-100/50 shadow-sm">
                            <p class="text-slate-500 text-[10px] uppercase tracking-wider font-bold mb-1"><?php echo $d[0]; ?></p>
                            <p class="text-slate-900 font-semibold text-sm"><?php echo $d[1]; ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
