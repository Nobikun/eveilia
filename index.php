<?php
require_once 'includes/functions.php';

get_header('Accueil', 'Votre baby planner de confiance pour organiser tous vos moments précieux de grossesse et maternité');
?>

<main>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container" style="padding: 0px;">
            <div class="hero-content">
                <div class="hero-visual">   
                    <img src="assets/img/cathedrale.png" alt="Baby planner illustration" class="hero-image" style="width: 100%;"/>
                </div>
            </div>
        </div>
    </section>

    <!-- Pourquoi nous choisir -->
    <section class="why-choose-us">
        <div class="container">
            <div class="section-header">
                <h2>Pourquoi choisir <span class="highlight"><?php echo SITE_NAME; ?></span> ?</h2>
            </div>
            <div class="why-content">
                <div class="benefits-grid">
                    <div class="benefit-card">
                        <h3>Expertise dédiée</h3>
                        <p>Spécialisée dans l'organisation d'événements liés à la maternité</p>
                    </div>
                    <div class="benefit-card">
                        <h3>Sur-mesure</h3>
                        <p>Chaque prestation est adaptée à vos envies et votre budget</p>
                    </div>
                    <div class="benefit-card">
                        <h3>Gain de temps</h3>
                        <p>Profitez de votre grossesse, nous nous occupons de tout</p>
                    </div>
                    <div class="benefit-card">
                        <h3>Accompagnement</h3>
                        <p>Un suivi personnalisé de A à Z pour votre tranquillité</p>
                    </div>
                </div>
                <aside class="why-aside">
                    <div class="why-photo-wrapper">
                        <img src="assets/img/photo.jpg" alt="Votre photo" class="why-photo" />
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Services en vedette -->
    <section class="featured-services">
        <div class="container">
            <div class="section-header">
                <h2>Les prestations</h2>
                <p>Découvrez comment je peux vous accompagner, à travers 5 pôles: l'aide administrative, le matériel de puériculture, le bien-être parental, la sécurité domestique et les modes de garde.</p>
            </div>
            
            <div class="services-grid">
                <?php
                
                    $serviceManager = new ServiceManager();
                    $featuredServices = array_filter($serviceManager->getAllServices(), function($service) {
                        return $service['is_featured'] == 1;
                    });
                    
                    $index = 0;
foreach (array_slice($featuredServices, 0, 5) as $service):
    $sideClass = ($index % 2 === 0) ? 'image-left' : 'image-right';
?>
<div class="service-card featured <?php echo $sideClass; ?>">
    <div class="service-image">
        <img src="assets/img/<?php echo $service['icon']; ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" />
    </div>

    <div class="service-content">
        <h3><?php echo htmlspecialchars($service['title']); ?></h3>
        <p><?php echo truncate($service['short_description'], 120); ?></p>
        <div class="service-price">
            <?php echo $serviceManager->formatPrice($service['price_from'], $service['price_to']); ?>
        </div>
        <a href="<?php echo $serviceManager->getServiceUrl($service['slug']); ?>" class="btn btn-primary">
            En savoir plus
        </a>
    </div>
</div>
<?php
    $index++;
endforeach;
?>
            </div>
            
            <div class="section-cta">
                <a href="<?php echo make_url('services.php'); ?>" class="btn btn-outline btn-large">
                    Voir tous nos services →
                </a>
            </div>
        </div>
    </section>

    <!-- CTA final -->
    <section class="final-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Prête à organiser <span class="highlight">votre événement</span> ?</h2>
                <p>Parlons de votre projet lors d'une consultation gratuite de 30 minutes</p>
                <div class="cta-actions">
                    <a href="<?php echo make_url('contact.php'); ?>" class="btn btn-primary btn-large">
                        🗓️ Réserver ma consultation
                    </a>
                    <a href="tel:<?php echo str_replace(' ', '', SITE_PHONE); ?>" class="btn btn-secondary btn-large">
                        📞 <?php echo SITE_PHONE; ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
    </section>
    <!-- Controls for live theme/font switching -->
    <div class="theme-controls" aria-hidden="false">
        <label style="display:none">Thème</label>
        <select name="theme-select" onchange="setTheme(this.value)">
            <option value="default">Default</option>
            <option value="pastel-rose">Pastel Rose</option>
            <option value="pastel-mint">Pastel Mint</option>
            <option value="pastel-lavender">Pastel Lavender</option>
            <option value="pastel-peach">Pastel Peach</option>
            <option value="pastel-sky">Pastel Sky</option>
            <option value="pastel-seafoam">Pastel Seafoam</option>
            <option value="pastel-coral">Pastel Coral</option>
            <option value="pastel-cream">Pastel Cream</option>
            <option value="pastel-midnight">Pastel Midnight</option>
        </select>

        <label style="display:none">Police</label>
        <select name="font-select" onchange="setFont(this.value)">
            <option value="default">Quicksand (par défaut)</option>
            <option value="playfair">Playfair Display</option>
            <option value="inter">Inter</option>
            <option value="montserrat">Montserrat</option>
            <option value="dream">Dreaming Outloud</option>
        </select>
    </div>
</main>

<?php get_footer(); ?>