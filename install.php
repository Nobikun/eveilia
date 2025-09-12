<?php
// Script d'installation automatique
require_once 'config/config.php';

$messages = [];
$errors = [];

if ($_POST && isset($_POST['install'])) {
    try {
        // Connexion à MySQL sans base de données
        $pdo = new PDO("mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Création de la base de données
        $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $messages[] = "✅ Base de données créée";
        
        // Connexion à la base de données
        $pdo->exec("USE " . DB_NAME);
        
        // Lecture et exécution du schéma SQL
        $sql = file_get_contents('database/schema.sql');
        $statements = explode(';', $sql);
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                $pdo->exec($statement);
            }
        }
        
        $messages[] = "✅ Tables créées et données d'exemple insérées";
        $messages[] = "✅ Installation terminée avec succès !";
        $messages[] = "🔐 Accès admin : admin / admin123";
        
    } catch (Exception $e) {
        $errors[] = "❌ Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - <?php echo SITE_NAME; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #f5f3ff, #e8e5ff); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .install-container { background: white; padding: 3rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); max-width: 600px; width: 100%; }
        h1 { color: #8B4593; text-align: center; margin-bottom: 2rem; }
        .message { padding: 1rem; margin: 1rem 0; border-radius: 8px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .btn { background: #8B4593; color: white; padding: 1rem 2rem; border: none; border-radius: 8px; font-size: 1.1rem; cursor: pointer; width: 100%; margin-top: 1rem; }
        .btn:hover { background: #7a3d82; }
        .info { background: #cce7ff; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; }
        .links { text-align: center; margin-top: 2rem; }
        .links a { color: #8B4593; text-decoration: none; margin: 0 1rem; }
    </style>
</head>
<body>
    <div class="install-container">
        <h1>🚀 Installation Baby Planner</h1>
        
        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $message): ?>
                <div class="message success"><?php echo htmlspecialchars($message); ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="message error"><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <?php if (empty($messages) && empty($errors)): ?>
            <div class="info">
                <h3>🎯 Prêt à installer ?</h3>
                <p>Cette installation va :</p>
                <ul style="margin: 1rem 0; padding-left: 2rem;">
                    <li>Créer la base de données <strong><?php echo DB_NAME; ?></strong></li>
                    <li>Créer toutes les tables nécessaires</li>
                    <li>Insérer des données d'exemple</li>
                    <li>Configurer les services de base</li>
                </ul>
            </div>
            
            <form method="POST">
                <button type="submit" name="install" class="btn">
                    🚀 Lancer l'installation
                </button>
            </form>
        <?php else: ?>
            <div class="links">
                <a href="index.php">🏠 Voir le site</a>
                <a href="admin/">🔧 Administration</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>