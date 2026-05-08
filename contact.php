<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Contact Us';
include __DIR__ . '/includes/header.php';
?>
<div class="min-h-screen bg-slate-50">
    <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-3">
            <div class="w-1.5 h-5 bg-amber-500 rounded-full"></div>
            <h1 class="text-lg font-bold text-slate-900">Contact Us</h1>
            <span class="text-slate-400 text-sm hidden sm:inline">— Get in touch with the RGIA office</span>
        </div>
    </div>
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-5 gap-12">
                <!-- Contact Info -->
                <div class="lg:col-span-2 space-y-8 animate-slide-in-left">
                    <div class="glass-card p-8">
                        <h3 class="text-xl font-bold text-slate-900 mb-6">Contact Information</h3>
                        <div class="space-y-6">
                            <div class="flex gap-4 group">
                                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900 mb-1">Office Address</p>
                                    <p class="text-slate-600 text-sm leading-relaxed"><?php echo SITE_ADDRESS; ?></p>
                                </div>
                            </div>
                            <div class="flex gap-4 group">
                                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900 mb-1">Email Us</p>
                                    <a href="mailto:<?php echo SITE_EMAIL; ?>" class="text-blue-600 hover:text-blue-800 text-sm transition-colors"><?php echo SITE_EMAIL; ?></a>
                                </div>
                            </div>
                            <div class="flex gap-4 group">
                                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900 mb-1">Call Us</p>
                                    <p class="text-slate-600 text-sm"><?php echo SITE_PHONE; ?></p>
                                    <p class="text-slate-600 text-sm mt-1"><?php echo SITE_PHONE2; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card p-2 h-64 overflow-hidden relative group">
                        <iframe src="https://maps.google.com/maps?q=Motilal%20Nehru%20National%20Institute%20of%20Technology%20Allahabad&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="border:0;border-radius:0.5rem" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-full h-full grayscale-[20%] hover:grayscale-0 transition-all duration-500" title="MNNIT Allahabad Location Map"></iframe>
                    </div>
                </div>
                <!-- Contact Form -->
                <div class="lg:col-span-3">
                    <div class="glass-card p-8 md:p-12 animate-fade-in-up">
                        <h3 class="text-2xl font-bold text-slate-900 mb-2">Send us a Message</h3>
                        <p class="text-slate-500 mb-8">Fill out the form below and our team will get back to you.</p>
                        <div id="contact-status" class="mb-8 hidden"></div>
                        <form id="contact-form" class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Your Name</label>
                                    <input type="text" id="name" name="name" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" placeholder="John Doe">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                                    <input type="email" id="email" name="email" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" placeholder="john@example.com">
                                </div>
                            </div>
                            <div>
                                <label for="subject" class="block text-sm font-medium text-slate-700 mb-2">Subject</label>
                                <input type="text" id="subject" name="subject" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" placeholder="How can we help?">
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-medium text-slate-700 mb-2">Message</label>
                                <textarea id="message" name="message" required rows="5" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all resize-none" placeholder="Write your message here..."></textarea>
                            </div>
                            <button type="submit" id="contact-submit" class="w-full py-4 px-6 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-semibold text-lg hover:shadow-lg transition-all disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <span>Send Message</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = document.getElementById('contact-submit');
    var status = document.getElementById('contact-status');
    btn.disabled = true;
    btn.innerHTML = '<div class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div><span>Sending...</span>';
    
    var data = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        subject: document.getElementById('subject').value,
        message: document.getElementById('message').value
    };
    
    fetch('<?php echo BASE_URL; ?>/api/contacts.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
        status.className = 'mb-8 p-4 rounded-xl text-sm flex items-start gap-3 bg-emerald-50 text-emerald-800 border border-emerald-200';
        status.innerHTML = '<svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>Message sent successfully! We will get back to you soon.';
        document.getElementById('contact-form').reset();
    })
    .catch(function() {
        status.className = 'mb-8 p-4 rounded-xl text-sm flex items-start gap-3 bg-red-50 text-red-800 border border-red-200';
        status.innerHTML = '<svg class="w-5 h-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>Failed to send message. Please try again.';
    })
    .finally(function() {
        btn.disabled = false;
        btn.innerHTML = '<span>Send Message</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>';
    });
});
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
