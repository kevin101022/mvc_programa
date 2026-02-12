<?php
$pageTitle = 'Dashboard - Gestión de Transversales';
$activeNavItem = 'dashboard';
require_once '../layouts/head.php';
require_once '../layouts/sidebar.php';
?>

<main class="main-content dashboard-content">
    <div class="dashboard-hero">
        <div class="hero-overlay"></div>
        <div class="welcome-container">
            <h1 class="welcome-title">BIENVENIDO AL<br><span>GESTOR DE TRANSVERSALES</span></h1>
            <p class="welcome-subtitle">Optimización y control de procesos académicos transversales</p>

            <div class="hero-actions">
                <a href="../sede/index.php" class="dashboard-btn primary">
                    <ion-icon name="business-outline"></ion-icon>
                    Gestionar Sedes
                </a>
                <a href="#" class="dashboard-btn secondary">
                    <ion-icon name="book-outline"></ion-icon>
                    Programas
                </a>
            </div>
        </div>
    </div>
</main>

</body>

</html>