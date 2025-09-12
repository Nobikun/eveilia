<?php
require_once 'includes/functions.php';
require_once 'includes/csrf.php';

$success = false;
$error = '';
$serviceSlug = isset($_GET['service']) ? sanitize($_GET['service']) : '';

if ($_POST) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = 'Erreur de sécurité. Veuillez réessayer.';
    } else {
        $name = sanitize($_POST['name'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $phone = sanitize($_POST['phone'] ?? '');
        $service = sanitize($_POST['service'] ?? '');
        $message = sanitize($_POST['message'] ?? '');
        
        if (empty($name) || empty($email) || empty($message)) {
            $error = 'Veuillez remplir tous les champs obligatoires.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Adresse email invalide.';
        } else {
            // Préparation de l'email
            $subject = "Nouvelle demande de contact - " . SITE_NAME;
            $emailContent = "
                <h2>Nouvelle demande de contact</h2>
                <p><strong>Nom:</strong> {$name}</p>
                <p><strong>Email:</strong> {$email}</p>
                <p><strong>Téléphone:</strong> {$phone}</p>
                <p><strong>Service demandé:</strong> {$service}</p>
                <p><strong>Message:</strong></p>
                <div style='background: #f5f5f5; padding: 15px; margin: 10px 0;'>
                    " . nl2br($message) . "
                </div>
            ";
            
            // Tentative d'envoi de l'email
            if (send_email(SITE_EMAIL, $subject, $emailContent, $email)) {
                $success = true;
                // Reset des variables pour éviter de pré-remplir le formulaire
                $name = $email = $phone = $service = $message = '';
            } else {
                $error = 'Erreur lors de l\'envoi du message. Veuillez réessayer ou nous contacter directement.';
            }
        }
    }
}

// Si un service est spécifié, on récupère ses infos
$selectedService = '';
if ($serviceSlug) {
    $serviceManager = new ServiceManager();
    $serviceData = $serviceManager->getServiceBySlug($serviceSlug);
    if ($serviceData) {
        $selectedService = $serviceData['title'];
    }
}

get_header('Contact', 'Contactez-nous pour organiser votre événement de maternité. Consultation gratuite et devis personnalisé.');
?>

<main>
    <section class="contact-header">
        <div class="container">
            <h1>Contactez-nous</h1>
            <p>Parlons de votre projet lors d'une consultation gratuite</p>
        </div>
    </section>

    <section class="contact-content">
        <div class="container">
            <div class="contact-layout">
                <div class="contact-info">
                    <h2>Restons en contact</h2>
                    <p>Nous sommes là pour répondre à toutes vos questions et vous accompagner dans la préparation de vos moments précieux.</p>
                    
                    <div class="contact-details">
                        <div class="contact-item">
                            <span class="contact-icon">📞</span>
                            <div>
                                <h4>Téléphone</h4>
                                <p><a href="tel:<?php echo str_replace(' ', '', SITE_PHONE); ?>"><?php echo SITE_PHONE; ?></a></p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <span class="contact-icon">✉️</span>
                            <div>
                                <h4>Email</h4>
                                <p><a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a></p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <span class="contact-icon">⏰</span>
                            <div>
                                <h4>Horaires</h4>
                                <p>Lun - Ven : 9h - 18h<br>Sam : 10h - 16h</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <span class="contact-icon">🎯</span>
                            <div>
                                <h4>Consultation gratuite</h4>
                                <p>30 minutes d'échanges pour définir vos besoins</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form-container">
                    <?php if ($success): ?>
                        <div class="success-message">
                            <div class="success-content">
                                <span class="success-icon">✅</span>
                                <h3>Message envoyé avec succès !</h3>
                                <p>Merci pour votre message. Nous vous recontacterons dans les plus brefs délais.</p>
                                <a href="services.php" class="btn btn-primary">Découvrir nos services</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php if ($error): ?>
                            <div class="error-message">
                                <span class="error-icon">❌</span>
                                <p><?php echo htmlspecialchars($error); ?></p>
                            </div>
                        <?php endif; ?>
                        <form method="POST" class="contact-form">
                            <?php echo csrf_token_field(); ?>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Nom complet *</label>
                                    <input type="text" id="name" name="name" required 
                                           value="<?php echo htmlspecialchars($name ?? ''); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" id="email" name="email" required 
                                           value="<?php echo htmlspecialchars($email ?? ''); ?>">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">Téléphone</label>
                                    <input type="tel" id="phone" name="phone" 
                                           value="<?php echo htmlspecialchars($phone ?? ''); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="service">Service souhaité</label>
                                    <select id="service" name="service">
                                        <option value="">Choisir un service...</option>
                                        <option value="Baby Shower" <?php echo ($selectedService === 'Baby Shower') ? 'selected' : ''; ?>>Baby Shower</option>
                                        <option value="Gender Reveal" <?php echo ($selectedService === 'Gender Reveal') ? 'selected' : ''; ?>>Gender Reveal</option>
                                        <option value="Baptême" <?php echo ($selectedService === 'Baptême') ? 'selected' : ''; ?>>Baptême</option>
                                        <option value="Premier anniversaire" <?php echo ($selectedService === 'Premier anniversaire') ? 'selected' : ''; ?>>Premier anniversaire</option>
                                        <option value="Photoshoot maternité" <?php echo ($selectedService === 'Photoshoot maternité') ? 'selected' : ''; ?>>Photoshoot maternité</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">Votre message *</label>
                                <textarea id="message" name="message" rows="5" required 
                                          placeholder="Décrivez-nous votre projet, vos attentes, la date souhaitée..."><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-large">
                                <span>📨</span> Envoyer le message
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.contact-header {
    padding: 120px 0 60px;
    background: linear-gradient(135deg, var(--violet-pale), var(--violet-light));
    text-align: center;
}

.contact-header h1 {
    font-size: 2.5rem;
    color: var(--violet-dark);
    margin-bottom: 1rem;
}

.contact-content {
    padding: 4rem 0;
}

.contact-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: start;
}

.contact-info {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}

.contact-info h2 {
    color: var(--violet-dark);
    margin-bottom: 1rem;
}

.contact-details {
    margin-top: 2rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: var(--violet-pale);
    border-radius: 10px;
}

.contact-icon {
    font-size: 1.5rem;
    flex-shrink: 0;
}

.contact-item h4 {
    color: var(--violet-dark);
    margin-bottom: 0.5rem;
}

.contact-item a {
    color: var(--violet-primary);
    text-decoration: none;
    font-weight: 500;
}

.contact-form-container {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}

.success-message, .error-message {
    padding: 2rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    text-align: center;
}

.success-message {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.error-message {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.success-icon, .error-icon {
    font-size: 2rem;
    display: block;
    margin-bottom: 1rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--violet-dark);
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.8rem;
    border: 2px solid var(--gray-light);
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--violet-primary);
    box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1.1rem;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

@media (max-width: 768px) {
    .contact-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
