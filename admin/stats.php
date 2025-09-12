<?php
require_once '../includes/functions.php';
require_once 'includes/admin-check.php';

$db = Database::getInstance();

// Statistiques basiques
$stats = [
    'services_total' => $db->query("SELECT COUNT(*) FROM services")->fetchColumn(),
    'services_active' => $db->query("SELECT COUNT(*) FROM services WHERE is_active = 1")->fetchColumn(),
    'services_featured' => $db->query("SELECT COUNT(*) FROM services WHERE is_featured = 1")->fetchColumn(),
    'messages_today' => 0, // À implémenter avec table contact_messages
];

$popularServices = $db->query("
    SELECT title, icon, 
           CASE WHEN is_featured THEN 'Vedette' ELSE 'Standard' END as status
    FROM services 
    WHERE is_active = 1 
    ORDER BY is_featured DESC, created_at DESC 
    LIMIT 5
")->fetchAll();

$recentActivity = [
    ['action' => 'Service créé', 'item' => 'Baby Shower Premium', 'time' => '2 heures ago'],
    ['action' => 'Message reçu', 'item' => 'Demande devis baptême', 'time' => '5 heures ago'],
    ['action' => 'Service modifié', 'item' => 'Gender Reveal', 'time' => '1 jour ago'],
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin-header.php'; ?>
        
        <div class="admin-content">
            <div class="container">
                <h1>📊 Tableau de bord</h1>
                
                <!-- Widgets statistiques -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">📋</div>
                        <div class="stat-info">
                            <h3><?php echo $stats['services_total']; ?></h3>
                            <p>Services créés</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">✅</div>
                        <div class="stat-info">
                            <h3><?php echo $stats['services_active']; ?></h3>
                            <p>Services actifs</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">⭐</div>
                        <div class="stat-info">
                            <h3><?php echo $stats['services_featured']; ?></h3>
                            <p>En vedette</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">📧</div>
                        <div class="stat-info">
                            <h3><?php echo $stats['messages_today']; ?></h3>
                            <p>Messages aujourd'hui</p>
                        </div>
                    </div>
                </div>
                
                <!-- Graphiques et listes -->
                <div class="dashboard-grid">
                    <!-- Services populaires -->
                    <div class="dashboard-card">
                        <h2>🔥 Services populaires</h2>
                        <div class="services-list-mini">
                            <?php foreach ($popularServices as $service): ?>
                                <div class="service-mini">
                                    <span class="service-icon"><?php echo $service['icon']; ?></span>
                                    <div class="service-mini-info">
                                        <strong><?php echo htmlspecialchars($service['title']); ?></strong>
                                        <span class="service-status <?php echo strtolower($service['status']); ?>">
                                            <?php echo $service['status']; ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Activité récente -->
                    <div class="dashboard-card">
                        <h2>📈 Activité récente</h2>
                        <div class="activity-list">
                            <?php foreach ($recentActivity as $activity): ?>
                                <div class="activity-item">
                                    <div class="activity-icon">🔄</div>
                                    <div class="activity-info">
                                        <p><strong><?php echo $activity['action']; ?></strong></p>
                                        <p><?php echo htmlspecialchars($activity['item']); ?></p>
                                        <small><?php echo $activity['time']; ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Actions rapides -->
                <div class="quick-actions">
                    <h2>⚡ Actions rapides</h2>
                    <div class="actions-grid">
                        <a href="services.php" class="action-card">
                            <span class="action-icon">➕</span>
                            <span>Nouveau service</span>
                        </a>
                        
                        <a href="../index.php" target="_blank" class="action-card">
                            <span class="action-icon">👀</span>
                            <span>Voir le site</span>
                        </a>
                        
                        <a href="messages.php" class="action-card">
                            <span class="action-icon">📧</span>
                            <span>Messages</span>
                        </a>
                        
                        <a href="backup.php" class="action-card">
                            <span class="action-icon">💾</span>
                            <span>Sauvegarde</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.stat-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: var(--transition);
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.stat-icon {
    font-size: 3rem;
    opacity: 0.8;
}

.stat-info h3 {
    font-size: 2.5rem;
    color: var(--violet-primary);
    margin: 0;
    font-weight: 700;
}

.stat-info p {
    margin: 0.5rem 0 0 0;
    color: #666;
    font-weight: 500;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 3rem;
}

.dashboard-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}

.dashboard-card h2 {
    color: var(--violet-dark);
    margin-bottom: 1.5rem;
}

.services-list-mini {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.service-mini {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--gray-light);
    border-radius: var(--border-radius);
}

.service-mini-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.service-status {
    font-size: 0.8rem;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    align-self: flex-start;
}

.service-status.vedette {
    background: #FFD700;
    color: #B8860B;
}

.service-status.standard {
    background: #E3F2FD;
    color: #1976D2;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    background: var(--gray-light);
    border-radius: var(--border-radius);
}

.activity-icon {
    font-size: 1.2rem;
    opacity: 0.7;
}

.activity-info p {
    margin: 0;
}

.activity-info small {
    color: #666;
    font-style: italic;
}

.quick-actions {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}

.quick-actions h2 {
    color: var(--violet-dark);
    margin-bottom: 1.5rem;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.action-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem;
    background: var(--gray-light);
    border-radius: var(--border-radius);
    text-decoration: none;
    color: var(--violet-dark);
    transition: var(--transition);
}

.action-card:hover {
    background: var(--violet-light);
    color: var(--white);
    transform: translateY(-2px);
}

.action-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        text-align: center;
        flex-direction: column;
    }
}
</style>

</body>
</html>
