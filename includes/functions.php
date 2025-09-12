<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/ServiceManager.php';

// Fonction de nettoyage des inputs
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Fonction pour truncate le texte
function truncate($text, $length = 100) {
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length) . '...';
}

// Fonction pour inclure le header
function get_header($pageTitle = '', $pageDescription = '') {
    $title = $pageTitle ? $pageTitle . ' - ' . SITE_NAME : SITE_NAME;
    $description = $pageDescription ?: SITE_DESCRIPTION;
    include 'includes/header.php';
}

// Fonction pour inclure le footer
function get_footer() {
    include 'includes/footer.php';
}

// Fonction pour générer une URL propre
function make_url($path) {
    return rtrim(SITE_URL, '/') . '/' . ltrim($path, '/');
}

// Fonction pour vérifier si c'est la page active
function is_active_page($page) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    return $currentPage === $page ? 'active' : '';
}

// Fonction pour générer un token CSRF
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Fonction pour vérifier le token CSRF
function verify_csrf_token($token) {
    return !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Fonction pour envoyer un email (simple)
function send_email($to, $subject, $message, $from = SITE_EMAIL) {
    $headers = [
        'From' => $from,
        'Reply-To' => $from,
        'Content-Type' => 'text/html; charset=UTF-8'
    ];
    
    return mail($to, $subject, $message, implode("\r\n", array_map(
        function($k, $v) { return "$k: $v"; },
        array_keys($headers),
        $headers
    )));
}
?>