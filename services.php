<?php
require_once 'includes/functions.php';

$serviceManager = new ServiceManager();
$categories = $serviceManager->getServiceCategories();
$selectedCategory = isset($_GET['category']) ? sanitize($_GET['category']) : '';

if ($selectedCategory) {
    $services = $serviceManager->getServicesByCategory($selectedCategory);
    $pageTitle = 'Services - ' . ucfirst($selectedCategory);
} else {
    $services = $serviceManager->getAllServices();
    $pageTitle = 'Tous nos services';
}

get_header($pageTitle, 'Découvrez tous nos services de baby planning pour organiser vos événements de maternité');
?>

<main>
    <section class="page-header">
        <div class="container">
            <h1><?php echo $selectedCategory ? 'Services : ' . ucfirst($selectedCategory) : 'Tous nos services'; ?></h1>
            <p>Des prestations sur-mesure pour tous vos moments précieux</p>
        </div>
    </section>

    <?php if (!empty($categories)): ?>
    <section class="service-filters">
        <div class="container">
            <div class="filter-tabs">
                <a href="services.php" class="filter-tab <?php echo !$selectedCategory ? 'active' : ''; ?>">
                    Tous les services
                </a>
                <?php foreach ($categories as $category): ?>
                    <a href="services.php?category=<?php echo urlencode($category['slug']); ?>" 
                       class="filter-tab <?php echo $selectedCategory === $category['slug'] ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($category['icon'] . ' ' . $category['name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="services-listing">
        <div class="container">
            <?php if (!empty($services)): ?>
                <div class="services-grid">
                    <?php foreach ($services as $service): 
                        $categories = $serviceManager->parseCategories($service['categories']);
                    ?>
                        <div class="service-card <?php echo $service['is_featured'] ? 'featured' : ''; ?>">
                            <div class="service-header">
                                <div class="service-icon"><?php echo htmlspecialchars($service['icon']); ?></div>
                                <div class="service-info">
                                    <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                                    <p><?php echo htmlspecialchars($service['short_description']); ?></p>
                                </div>
                                <div class="service-price-badge">
                                    <?php echo $serviceManager->formatPrice($service['price_from'], $service['price_to']); ?>
                                </div>
                            </div>
                            
                            <?php if (!empty($categories)): ?>
                                <div class="service-categories">
                                    <?php foreach ($categories as $cat): ?>
                                        <span class="category-tag" style="background-color: <?php echo htmlspecialchars($cat['color']); ?>">
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="service-actions">
                                <a href="<?php echo $serviceManager->getServiceUrl($service['slug']); ?>" 
                                   class="btn btn-primary">
                                    Découvrir
                                </a>
                                <a href="contact.php?service=<?php echo urlencode($service['slug']); ?>" 
                                   class="btn btn-outline">
                                    Devis
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-services">
                    <h3>Aucun service trouvé</h3>
                    <p>Revenez bientôt pour découvrir nos prestations !</p>
                    <a href="services.php" class="btn btn-primary">Voir tous les services</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<style>
.page-header {
    padding: 120px 0 60px;
    background: linear-gradient(135deg, var(--violet-pale), var(--violet-light));
    text-align: center;
}

.page-header h1 {
    font-size: 2.5rem;
    color: var(--violet-dark);
    margin-bottom: 1rem;
}

.service-filters {
    background: var(--white);
    padding: 2rem 0;
    border-bottom: 1px solid var(--gray-light);
}

.filter-tabs {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.filter-tab {
    padding: 0.8rem 1.5rem;
    border: 2px solid var(--violet-light);
    border-radius: 25px;
    text-decoration: none;
    color: var(--violet-primary);
    font-weight: 500;
    transition: var(--transition);
}

.filter-tab:hover, .filter-tab.active {
    background: var(--violet-primary);
    color: var(--white);
    border-color: var(--violet-primary);
}

.services-listing {
    padding: 4rem 0;
}

.service-header {
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 1rem;
    align-items: start;
    margin-bottom: 1rem;
}

.service-price-badge {
    background: var(--violet-light);
    color: var(--violet-dark);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
}

.service-categories {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}

.category-tag {
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
}

.service-actions {
    display: flex;
    gap: 1rem;
}

.no-services {
    text-align: center;
    padding: 4rem 2rem;
}

@media (max-width: 768px) {
    .service-header {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .service-actions {
        justify-content: center;
    }
    
    .filter-tabs {
        padding: 0 1rem;
    }
}
</style>

<?php get_footer(); ?>
