<?php
require_once '../includes/functions.php';
require_once 'includes/admin-check.php';

$serviceManager = new ServiceManager();
$message = '';
$error = '';

// Traitement des actions
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                if ($serviceManager->createService($_POST)) {
                    $message = 'Service créé avec succès !';
                } else {
                    $error = 'Erreur lors de la création du service.';
                }
                break;
                
            case 'update':
                if ($serviceManager->updateService($_POST['id'], $_POST)) {
                    $message = 'Service mis à jour avec succès !';
                } else {
                    $error = 'Erreur lors de la mise à jour.';
                }
                break;
                
            case 'delete':
                if ($serviceManager->deleteService($_POST['id'])) {
                    $message = 'Service supprimé avec succès !';
                } else {
                    $error = 'Erreur lors de la suppression.';
                }
                break;
        }
    }
}

$services = $serviceManager->getAllServices();
$editService = null;

if (isset($_GET['edit'])) {
    $editService = $serviceManager->getServiceById($_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des services - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/admin-header.php'; ?>
        
        <div class="admin-content">
            <div class="container">
                <h1>Gestion des services</h1>
                
                <?php if ($message): ?>
                    <div class="success-message">
                        <span class="success-icon">✅</span>
                        <p><?php echo htmlspecialchars($message); ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="error-message">
                        <span class="error-icon">❌</span>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Formulaire d'ajout/modification -->
                <div class="admin-form-card">
                    <h2><?php echo $editService ? 'Modifier le service' : 'Ajouter un service'; ?></h2>
                    
                    <form method="POST" class="service-form">
                        <?php if ($editService): ?>
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?php echo $editService['id']; ?>">
                        <?php else: ?>
                            <input type="hidden" name="action" value="create">
                        <?php endif; ?>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="title">Titre du service *</label>
                                <input type="text" id="title" name="title" required 
                                       value="<?php echo htmlspecialchars($editService['title'] ?? ''); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="icon">Icône (emoji)</label>
                                <input type="text" id="icon" name="icon" placeholder="🎈" maxlength="10"
                                       value="<?php echo htmlspecialchars($editService['icon'] ?? ''); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="short_description">Description courte *</label>
                            <textarea id="short_description" name="short_description" rows="2" required 
                                      placeholder="Description qui apparaît sur la page services..."><?php echo htmlspecialchars($editService['short_description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="full_description">Description complète *</label>
                            <textarea id="full_description" name="full_description" rows="4" required 
                                      placeholder="Description détaillée qui apparaît sur la page du service..."><?php echo htmlspecialchars($editService['full_description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="included_services">Services inclus</label>
                            <textarea id="included_services" name="included_services" rows="3"
                                      placeholder="Service 1|Service 2|Service 3 (séparés par des |)"><?php echo htmlspecialchars($editService['included_services'] ?? ''); ?></textarea>
                            <small>Séparez chaque service inclus par le caractère |</small>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="price_from">Prix à partir de (€)</label>
                                <input type="number" step="0.01" id="price_from" name="price_from"
                                       value="<?php echo $editService['price_from'] ?? ''; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="price_to">Prix jusqu'à (€)</label>
                                <input type="number" step="0.01" id="price_to" name="price_to"
                                       value="<?php echo $editService['price_to'] ?? ''; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="duration">Durée</label>
                                <input type="text" id="duration" name="duration" placeholder="4-6 heures"
                                       value="<?php echo htmlspecialchars($editService['duration'] ?? ''); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="meta_description">Description SEO</label>
                            <textarea id="meta_description" name="meta_description" rows="2"
                                      placeholder="Description pour les moteurs de recherche..."><?php echo htmlspecialchars($editService['meta_description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-checkboxes">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_active" value="1" 
                                       <?php echo ($editService['is_active'] ?? true) ? 'checked' : ''; ?>>
                                Service actif
                            </label>
                            
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_featured" value="1"
                                       <?php echo ($editService['is_featured'] ?? false) ? 'checked' : ''; ?>>
                                Service en vedette
                            </label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <?php echo $editService ? '💾 Mettre à jour' : '➕ Créer le service'; ?>
                            </button>
                            
                            <?php if ($editService): ?>
                                <a href="services.php" class="btn btn-outline">Annuler</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <!-- Liste des services -->
                <div class="services-list">
                    <h2>Services existants (<?php echo count($services); ?>)</h2>
                    
                    <?php if (empty($services)): ?>
                        <p class="no-services">Aucun service créé pour le moment.</p>
                    <?php else: ?>
                        <div class="services-table">
                            <?php foreach ($services as $service): ?>
                                <div class="service-item">
                                    <div class="service-info">
                                        <div class="service-header">
                                            <span class="service-icon"><?php echo $service['icon']; ?></span>
                                            <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                                            <div class="service-badges">
                                                <?php if ($service['is_featured']): ?>
                                                    <span class="badge badge-featured">⭐ Vedette</span>
                                                <?php endif; ?>
                                                <?php if (!$service['is_active']): ?>
                                                    <span class="badge badge-inactive">❌ Inactif</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <p class="service-description">
                                            <?php echo htmlspecialchars($service['short_description']); ?>
                                        </p>
                                        
                                        <div class="service-meta">
                                            <?php if ($service['price_from']): ?>
                                                <span class="service-price">
                                                    💰 À partir de <?php echo number_format($service['price_from'], 0, ',', ' '); ?>€
                                                </span>
                                            <?php endif; ?>
                                            
                                            <?php if ($service['duration']): ?>
                                                <span class="service-duration">
                                                    ⏱️ <?php echo htmlspecialchars($service['duration']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="service-actions">
                                        <a href="?edit=<?php echo $service['id']; ?>" class="btn btn-sm btn-outline">
                                            ✏️ Modifier
                                        </a>
                                        
                                        <form method="POST" style="display: inline;" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo  $ service['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                🗑️ Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<style>
.admin-form-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    margin-bottom: 3rem;
}

.admin-form-card h2 {
    color: var(--violet-dark);
    margin-bottom: 2rem;
}

.service-form .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.service-form .form-row:has(> .form-group:nth-child(3)) {
    grid-template-columns: 1fr 1fr 1fr;
}

.form-checkboxes {
    display: flex;
    gap: 2rem;
    margin: 1.5rem 0;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    cursor: pointer;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.services-list {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}

.services-list h2 {
    color: var(--violet-dark);
    margin-bottom: 2rem;
}

.services-table {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.service-item {
    border: 2px solid var(--gray-light);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    transition: var(--transition);
}

.service-item:hover {
    border-color: var(--violet-light);
    box-shadow: var(--shadow);
}

.service-info {
    flex: 1;
}

.service-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.service-icon {
    font-size: 1.5rem;
    flex-shrink: 0;
}

.service-header h3 {
    color: var(--violet-dark);
    margin: 0;
}

.service-badges {
    display: flex;
    gap: 0.5rem;
    margin-left: auto;
}

.badge {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
    border-radius: 15px;
    font-weight: 500;
}

.badge-featured {
    background: #FFD700;
    color: #B8860B;
}

.badge-inactive {
    background: #FFE6E6;
    color: #D32F2F;
}

.service-description {
    color: #666;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.service-meta {
    display: flex;
    gap: 1.5rem;
    font-size: 0.9rem;
    color: var(--violet-primary);
}

.service-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    flex-shrink: 0;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

.btn-danger {
    background: #dc3545;
    color: white;
    border: 2px solid #dc3545;
}

.btn-danger:hover {
    background: #c82333;
    border-color: #c82333;
}

.no-services {
    text-align: center;
    color: #666;
    padding: 3rem;
    font-style: italic;
}

@media (max-width: 768px) {
    .service-form .form-row {
        grid-template-columns: 1fr;
    }
    
    .service-item {
        flex-direction: column;
        gap: 1rem;
    }
    
    .service-actions {
        flex-direction: row;
        align-self: stretch;
    }
    
    .form-checkboxes {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
</body>
</html>
