<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
    
    <!-- Fonts Google -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap">
    
    <!-- CSS principal -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Theme switcher (deferred) -->
    <script src="assets/js/theme-switcher.js" defer></script>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <a href="<?php echo make_url('index.php'); ?>">
                    <span class="brand-text"><?php echo SITE_NAME; ?></span>
                </a>
            </div>
            
            <div class="nav-menu" id="nav-menu">
                <a href="<?php echo make_url('index.php'); ?>" class="nav-link <?php echo is_active_page('index.php'); ?>">
                    Accueil
                </a>
                <a href="<?php echo make_url('services.php'); ?>" class="nav-link <?php echo is_active_page('services.php'); ?>">
                    Services
                </a>
                <a href="<?php echo make_url('about.php'); ?>" class="nav-link <?php echo is_active_page('about.php'); ?>">
                    À propos
                </a>
                <a href="<?php echo make_url('contact.php'); ?>" class="nav-link <?php echo is_active_page('contact.php'); ?>">
                    Contact
                </a>
                <a href="<?php echo make_url('contact.php'); ?>" class="btn btn-primary btn-nav">
                    Devis gratuit
                </a>
            </div>
            
            <div class="nav-toggle" id="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>