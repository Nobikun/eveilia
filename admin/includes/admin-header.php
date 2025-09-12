<header class="admin-header">
    <div class="container">
        <div class="admin-nav">
            <div class="admin-logo">
                <a href="index.php">👶 Admin - <?php echo SITE_NAME; ?></a>
            </div>
            
            <nav class="admin-menu">
                <a href="index.php">Tableau de bord</a>
                <a href="services.php">Services</a>
                <a href="../index.php" target="_blank">Voir le site</a>
                <a href="logout.php" class="logout-btn">Déconnexion</a>
            </nav>
        </div>
    </div>
</header>

<style>
.admin-header {
    background: var(--violet-dark);
    color: var(--white);
    padding: 1rem 0;
    margin-bottom: 2rem;
}

.admin-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.admin-logo a {
    color: var(--white);
    text-decoration: none;
    font-weight: bold;
    font-size: 1.2rem;
}

.admin-menu {
    display: flex;
    gap: 2rem;
    align-items: center;
}

.admin-menu a {
    color: var(--white);
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: var(--border-radius);
    transition: var(--transition);
}

.admin-menu a:hover {
    background: rgba(255, 255, 255, 0.1);
}

.logout-btn {
    background: rgba(255, 255, 255, 0.2) !important;
}
</style>
