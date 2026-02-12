<?php
$activeNavItem = isset($activeNavItem) ? $activeNavItem : 'sedes';
?>
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <img src="../../imagenes/LOGOsena.png" alt="SENA Logo" class="logo-img">
            <div class="logo-divider"></div>
            <span class="logo-text">Gestión de Transversales</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <p class="nav-section">Principal</p>
        <a href="../dashboard/index.php" class="nav-item <?php echo ($activeNavItem === 'dashboard') ? 'active' : ''; ?>">
            <ion-icon name="grid-outline"></ion-icon>
            Dashboard
        </a>

        <p class="nav-section">Gestión</p>
        <a href="../sede/index.php" class="nav-item <?php echo ($activeNavItem === 'sedes') ? 'active' : ''; ?>">
            <ion-icon name="business-outline"></ion-icon>
            Sedes
        </a>
        <a href="#" class="nav-item <?php echo ($activeNavItem === 'programas') ? 'active' : ''; ?>">
            <ion-icon name="school-outline"></ion-icon>
            Programas
        </a>
        <a href="#" class="nav-item <?php echo ($activeNavItem === 'instructores') ? 'active' : ''; ?>">
            <ion-icon name="people-outline"></ion-icon>
            Instructores
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-profile">
            <img src="../../assets/img/profile.jpg" alt="Coordinador" class="profile-img">
            <div class="profile-info">
                <p class="profile-name">Carlos Rodriguez</p>
                <p class="profile-role">Coordinador Académico</p>
            </div>
            <ion-icon name="log-out-outline"></ion-icon>
        </div>
    </div>
</aside>