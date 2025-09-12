<?php
// Configuration principale du site
define('SITE_NAME', 'L\'éveil Parental');
define('SITE_URL', 'http://localhost/eveilia');
define('SITE_EMAIL', 'malvina@leveilparental.fr');
define('SITE_PHONE', '07 56 80 93 39');
define('SITE_DESCRIPTION', 'Votre baby planner de confiance pour organiser tous vos moments précieux');

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'eveilparent');
define('DB_USER', 'eveilia');
define('DB_PASS', 'Thomina95&');
define('DB_CHARSET', 'utf8mb4');

// Configuration admin
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', password_hash('admin123', PASSWORD_DEFAULT));

// Timezone
date_default_timezone_set('Europe/Paris');

// Démarrage de la session si pas déjà fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>