<footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>
                        <span class="brand-icon">👶</span>
                        <?php echo SITE_NAME; ?>
                    </h3>
                    <p><?php echo SITE_DESCRIPTION; ?></p>
                    <div class="footer-contact">
                        <p>📞 <a href="tel:<?php echo str_replace(' ', '', SITE_PHONE); ?>"><?php echo SITE_PHONE; ?></a></p>
                        <p>✉️ <a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a></p>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h4>Services</h4>
                    <?php
                    try {
                        $serviceManager = new ServiceManager();
                        $featuredServices = array_slice($serviceManager->getAllServices(), 0, 4);
                        foreach ($featuredServices as $service): ?>
                            <p><a href="<?php echo $serviceManager->getServiceUrl($service['slug']); ?>">
                                <?php echo htmlspecialchars($service['title']); ?>
                            </a></p>
                    <?php endforeach;
                    } catch (Exception $e) {
                        echo '<p>Nos services vous attendent...</p>';
                    } ?>
                </div>
                
                <div class="footer-section">
                    <h4>Liens rapides</h4>
                    <p><a href="<?php echo make_url('about.php'); ?>">À propos</a></p>
                    <p><a href="<?php echo make_url('services.php'); ?>">Tous les services</a></p>
                    <p><a href="<?php echo make_url('contact.php'); ?>">Contact</a></p>
                    <p><a href="<?php echo make_url('admin/'); ?>">Admin</a></p>
                </div>
                
                <div class="footer-section">
                    <h4>Suivez-nous</h4>
                    <div class="footer-social">
                        <a href="#" class="social-link">📘 Facebook</a>
                        <a href="#" class="social-link">📷 Instagram</a>
                        <a href="#" class="social-link">🐦 Twitter</a>
                    </div>
                    <div class="footer-cta">
                        <a href="<?php echo make_url('contact.php'); ?>" class="btn btn-primary">
                            💌 Consultation gratuite
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Tous droits réservés.</p>
                <p>Fait avec 💜 pour les futures mamans</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
    <script>
        // Navigation mobile
        document.getElementById('nav-toggle').addEventListener('click', function() {
            document.getElementById('nav-menu').classList.toggle('active');
            this.classList.toggle('active');
        });
    </script>
</body>
</html>