<?php
require_once '../includes/functions.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_POST) {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD)) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Identifiants incorrects.';
    }
}
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
    <div class="admin-login">
        <div class="login-container">
            <div class="login-header">
                <h1>👶 Administration</h1>
                <p><?php echo SITE_NAME; ?></p>
            </div>
            
            <?php if ($error): ?>
                <div class="error-message">
                    <span class="error-icon">❌</span>
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" required 
                           value="<?php echo htmlspecialchars($username ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">
                    🔐 Se connecter
                </button>
            </form>
            
            <div class="login-footer">
                <a href="../index.php">← Retour au site</a>
            </div>
        </div>
    </div>

<style>
.admin-login {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--violet-pale), var(--violet-light));
    padding: 2rem;
}

.login-container {
    background: var(--white);
    padding: 3rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-hover);
    width: 100%;
    max-width: 400px;
}

.login-header {
    text-align: center;
    margin-bottom: 2rem;
}

.login-header h1 {
    color: var(--violet-dark);
    margin-bottom: 0.5rem;
}

.login-header p {
    color: #666;
    font-size: 0.9rem;
}

.login-form {
    margin-bottom: 2rem;
}

.login-footer {
    text-align: center;
}

.login-footer a {
    color: var(--violet-primary);
    text-decoration: none;
    font-size: 0.9rem;
}

.login-footer a:hover {
    text-decoration: underline;
}
</style>
</body>
</html>
