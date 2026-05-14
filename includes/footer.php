</main>
<!-- ========== FOOTER ========== -->
<footer class="bg-slate-900 border-t border-slate-800 text-slate-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Branding -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="<?php echo BASE_URL; ?>/public/mnnitlogo.jpg"
                        alt="Motilal Nehru National Institute of Technology Allahabad Logo"
                        class="w-12 h-12 object-contain bg-white rounded-full p-1">
                    <div>
                        <h3 class="text-white font-bold text-lg">Dean RGIA</h3>
                        <p class="text-teal-400 text-xs"><?php echo SITE_FULL_NAME; ?></p>
                    </div>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed">
                    <?php echo SITE_INSTITUTION; ?>
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Quick Links</h4>
                <div class="grid grid-cols-2 gap-2">
                    <a href="<?php echo BASE_URL; ?>/"
                        class="text-slate-400 hover:text-teal-400 text-sm transition-colors">Home</a>
                    <a href="<?php echo BASE_URL; ?>/publications.php"
                        class="text-slate-400 hover:text-teal-400 text-sm transition-colors">Publications</a>
                    <a href="<?php echo BASE_URL; ?>/dean-rgia.php"
                        class="text-slate-400 hover:text-teal-400 text-sm transition-colors">Dean RGIA</a>
                    <a href="<?php echo BASE_URL; ?>/resource-generation.php"
                        class="text-slate-400 hover:text-teal-400 text-sm transition-colors">Resource Generation</a>
                    <a href="<?php echo BASE_URL; ?>/team.php"
                        class="text-slate-400 hover:text-teal-400 text-sm transition-colors">Team</a>
                    <a href="<?php echo BASE_URL; ?>/souvenir.php"
                        class="text-slate-400 hover:text-teal-400 text-sm transition-colors">Souvenir</a>
                    <a href="<?php echo BASE_URL; ?>/contact.php"
                        class="text-slate-400 hover:text-teal-400 text-sm transition-colors">Contact</a>
                </div>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Contact</h4>
                <div class="space-y-3 text-sm text-slate-400">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-1 text-teal-400 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span><?php echo SITE_ADDRESS; ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-400 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span><?php echo SITE_EMAIL; ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-400 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span><?php echo SITE_PHONE; ?> <br> <?php echo SITE_PHONE2; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-slate-800 flex flex-col items-center justify-center gap-2 text-center">
            <p class="text-slate-500 text-sm">
                &copy; <?php echo date('Y'); ?> <?php echo SITE_INSTITUTION; ?>. All rights reserved.
            </p>
        </div>
    </div>
</footer>

<!-- App JS -->
<script src="<?php echo BASE_URL; ?>/assets/js/app.js"></script>
</body>

</html>