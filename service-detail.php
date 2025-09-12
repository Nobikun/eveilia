<?php
require_once 'includes/functions.php';

$serviceSlug = isset($_GET['service']) ? sanitize($_GET['service']) : '';
if (!$serviceSlug) {
    header('Location: services.php');
    exit;
}

$serviceManager = new ServiceManager();
$service = $serviceManager->getServiceBySlug($serviceSlug);

if (!$service) {
    header('Location: services.php');
    exit;
}

$categories = $serviceManager->getServiceCategories($service['id']);
$relatedServices = array_slice($serviceManager->getAllServices(), 0, 3);

get_header(
    htmlspecialchars($service['title']), 
    $service['meta_description'] ?: truncate($service['short_description'], 160)
);
?>

<main>
    <section class="service-detail-header">
        <div class="container">
            <nav class="breadcrumb">
                <a href="index.php">Accueil</a> / 
                <a href="services.php">Services</a> / 
                <span><?php echo htmlspecialchars($service['title']); ?></span>
            </nav>
            
            <div class="service-hero">
                <div class="service-hero-content">
                    <div class="service-icon-large">
                        <?php echo htmlspecialchars($service['icon']); ?>
                    </div>
                    <div>
                        <h1><?php echo htmlspecialchars($service['title']); ?></h1>
                        <p class="service-subtitle"><?php echo htmlspecialchars($service['full_description']); ?></p>
                        <div class="service-price-hero">
                            <?php echo $serviceManager->formatPrice($service['price_from'], $service['price_to']); ?>
                        </div>
                    </div>
                </div>
                
                <!--?php if (!empty($categories)): ?>
                    <div class="service-categories-hero"-->
                        <!--?php foreach ($categories as $category): ?>
                            <span class="category-badge-large" style="background-color: --><!--?php echo htmlspecialchars($category['color']); ?>"-->
                                <!--?php echo htmlspecialchars($category['icon'] . ' ' . $category['name']); ?-->
                            <!--/span-->
                        <!--?php endforeach; ?-->
                    <!--/div-->
                <!--?php endif; ?> -->
            </div>
        </div>
    </section>

    <section class="service-content">
        <div class="container">
            <div class="service-layout">
                <div class="service-main">

                    <?php if (!empty($service['included_services'])): ?>
                        <div class="service-includes">
                            <h2>Ce qui est inclus</h2>
                            <div class="includes-list">
                                <?php 
                                $includes = explode("|", $service['included_services']);
                                foreach ($includes as $include): 
                                    if (trim($include)):
                                ?>
                                    <div class="include-item">
                                        <span class="include-icon">✓</span>
                                        <span><?php echo htmlspecialchars(trim($include)); ?></span>
                                    </div>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                        </div>
                    <?php endif; ?> <br/>
                    <h2>Pack Internet</h2>
                    <div class="description-content">
                        <p>Le Pack Internet est une solution complète pour assurer une connexion fiable et rapide à domicile. 
                           Il inclut l'installation, la configuration et le support technique pour garantir une expérience optimale.</p>
                        <ul>
                            <li>Installation de la box internet</li>
                            <li>Configuration du réseau Wi-Fi</li>
                            <li>Support technique 24/7</li>
                            <li>Options de sécurité avancées</li>
                        </ul>
                            </div>
                </div>
                
                <div class="service-sidebar">
                    <div class="booking-card">
                        <h3>Informations pratiques</h3>
                        
                        <div class="booking-info">
                            <div class="info-item">
                                <span class="info-icon">💰</span>
                                <div>
                                    <strong>Tarif</strong>
                                    <p><?php echo $serviceManager->formatPrice($service['price_from'], $service['price_to']); ?></p>
                                </div>
                            </div>
                            
                            <?php if ($service['duration']): ?>
                                <div class="info-item">
                                    <span class="info-icon">⏱️</span>
                                    <div>
                                        <strong>Durée</strong>
                                        <p><?php echo htmlspecialchars($service['duration']); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="info-item">
                                <span class="info-icon">📞</span>
                                <div>
                                    <strong>Contact</strong>
                                    <p><a href="tel:<?php echo str_replace(' ', '', SITE_PHONE); ?>"><?php echo SITE_PHONE; ?></a></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="booking-actions">
                            <a href="contact.php?service=<?php echo urlencode($service['slug']); ?>" 
                               class="btn btn-primary btn-block">
                                📋 Demander un devis
                            </a>
                            <a href="contact.php" class="btn btn-outline btn-block">
                                💬 Consultation gratuite
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (!empty($relatedServices)): ?>
        <section class="related-services">
            <div class="container">
                <h2>Autres services qui pourraient vous intéresser</h2>
                <div class="related-grid">
                    <?php foreach ($relatedServices as $relatedService): 
                        if ($relatedService['id'] == $service['id']) continue;
                    ?>
                        <div class="related-card">
                            <div class="related-icon"><?php echo htmlspecialchars($relatedService['icon']); ?></div>
                            <h4><?php echo htmlspecialchars($relatedService['title']); ?></h4>
                            <p><?php echo truncate($relatedService['short_description'], 80); ?></p>
                            <div class="related-price">
                                <?php echo $serviceManager->formatPrice($relatedService['price_from'], $relatedService['price_to']); ?>
                            </div>
                            <a href="<?php echo $serviceManager->getServiceUrl($relatedService['slug']); ?>" 
                               class="btn btn-primary btn-small">
                                Découvrir
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<style>
.service-detail-header {
    padding: 120px 0 60px;
    background: linear-gradient(135deg, var(--violet-pale), var(--violet-light));
}

.breadcrumb {
    margin-bottom: 2rem;
    color: #666;
}

.breadcrumb a {
    color: var(--violet-primary);
    text-decoration: none;
}

.service-hero {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}

.service-hero-content {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.service-icon-large {
    font-size: 4rem;
    flex-shrink: 0;
}

.service-hero h1 {
    font-size: 2.5rem;
    color: var(--violet-dark);
    margin-bottom: 1rem;
}

.service-subtitle {
    font-size: 1.2rem;
    color: #666;
    margin-bottom: 1rem;
}

.service-price-hero {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--violet-primary);
}

.service-categories-hero {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.category-badge-large {
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
}

.service-content {
    padding: 4rem 0;
}

.service-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
}

.service-main {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}

.service-main h2 {
    color: var(--violet-dark);
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--violet-light);
}

.description-content {
    line-height: 1.8;
    margin-bottom: 2rem;
}

.includes-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.include-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.8rem;
    background: var(--violet-pale);
    border-radius: 8px;
}

.include-icon {
    color: var(--violet-primary);
    font-weight: bold;
    font-size: 1.2rem;
}

.booking-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    position: sticky;
    top: 100px;
}

.booking-card h3 {
    color: var(--violet-dark);
    margin-bottom: 1.5rem;
    text-align: center;
}

.booking-info {
    margin-bottom: 2rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--gray-light);
}

.info-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.info-icon {
    font-size: 1.5rem;
}

.info-item strong {
    color: var(--violet-dark);
    display: block;
    margin-bottom: 0.5rem;
}

.booking-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.btn-block {
    width: 100%;
    text-align: center;
}

.btn-small {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

.related-services {
    padding: 4rem 0;
    background: var(--violet-pale);
}

.related-services h2 {
    text-align: center;
    color: var(--violet-dark);
    margin-bottom: 3rem;
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.related-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    text-align: center;
    transition: var(--transition);
}

.related-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
}

.related-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.related-card h4 {
    color: var(--violet-dark);
    margin-bottom: 1rem;
}

.related-price {
    font-weight: 600;
    color: var(--violet-primary);
    margin: 1rem 0;
}

@media (max-width: 768px) {
    .service-hero-content {
        flex-direction: column;
        text-align: center;
    }
    
    .service-layout {
        grid-template-columns: 1fr;
    }
    
    .booking-card {
        position: static;
    }
}
</style>

<?php get_footer(); ?>
