<?php
require_once '../includes/functions.php';
require_once 'includes/admin-check.php';

$serviceManager = new ServiceManager();
$stats = [
    'total_services' => count($serviceManager->getAllServices()),
    'active_services' => count($serviceManager->getAllServices()),
    'featured_services' => count($serviceManager->getAllServices())
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin-header.php'; ?>
        
        <div class="admin-content">
            <div class="container">
                <h1>Tableau de bord</h1>
                
                <div class="admin-stats">
                    <div class="stat-card">
                        <div class="stat-icon">📋</div>
                        <div class="stat-info">
                            <h3><?php echo $stats['total_services']; ?></h3>
                            <p>Services total</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">✅</div>
                        <div class="stat-info">
                            <h3><?php echo $stats['active_services']; ?></h3>
                            <p>Services actifs</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">⭐</div>
                        <div class="stat-info">
                            <h3><?php echo $stats['featured_services']; ?></h3>
                            <p>Services en vedette</p>
                        </div>
                    </div>
                </div>
                
                <div class="admin-actions">
                    <div class="action-card">
                        <h3>📋 Gérer les services</h3>
                        <p>Ajouter, modifier ou supprimer des services</p>
                        <a href="services.php" class="btn btn-primary">Gérer les services</a>
                    </div>
                    
                    <div class="action-card">
                        <h3>🏷️ Gérer les catégories</h3>
                        <p>Organiser les services par catégories</p>
                        <a href="categories.php" class="btn btn-outline">Gérer les catégories</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
.admin-layout {
    min-height: 100vh;
    background: var(--gray-light);
}

.admin-content {
    padding: 2rem 0;
}

.admin-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin: 2rem 0;
}

.stat-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    font-size: 2.5rem;
}

.stat-info h3 {
    font-size: 2rem;
    color: var(--violet-primary);
    margin-bottom: 0.5rem;
}

.stat-info p {
    color: #666;
    font-size: 0.9rem;
}

.admin-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.action-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    text-align: center;
}

.action-card h3 {
    color: var(--violet-dark);
    margin-bottom: 1rem;
}

.action-card p {
    color: #666;
    margin-bottom: 1.5rem;
}
</style>
</body>
</html>
