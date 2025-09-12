<?php
/**
 * Fonctions de protection CSRF
 */

if (!function_exists('generate_csrf_token')) {
    /**
     * Génère un token CSRF
     */
    function generate_csrf_token() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_token_field')) {
    /**
     * Génère le champ hidden pour le token CSRF
     */
    function csrf_token_field() {
        $token = generate_csrf_token();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }
}

if (!function_exists('verify_csrf_token')) {
    /**
     * Vérifie la validité du token CSRF
     */
    function verify_csrf_token($token) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['csrf_token']) && 
               hash_equals($_SESSION['csrf_token'], $token);
    }
}
?>
