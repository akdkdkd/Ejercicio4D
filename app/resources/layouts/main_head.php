<?php
function setHeader($args){
    $ua = as_object($args->ua);
    $currentUri = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="es">
<head>    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?=CSS?>bootstrap.css">
    
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title><?=$args->title?></title>
    <style>
        body {
            color: #888;
            background-color : #CCC;
        }
    </style> 
</head>
<body class="">


    <?php if($currentUri !== '/Session/iniSession'): ?>
    <!-- Sidebar / barra lateral -->
    <section id="sidebar" class="sidebar">
        <a href="/" class="brand"><i class='bx bx-plus-medical'></i>Purple label</a>
        <ul class="side-menu">
            <?php if ($currentUri !== '/' && $currentUri !== '/Miscitas') : ?>
            <li><a href="/dashboard"><i class='bx bxs-dashboard icon'></i>Dashboard</a></li>
            <li><a href="/lista"><i class='bx bx-list-ul icon'></i>Lista</a></li>
            <?php else: ?>
            <li><a href="/"><i class='bx bxs-dashboard icon'></i>Agendar citas</a></li>
            <li><a href="/Miscitas"><i class='bx bxs-dashboard icon'></i>Mis citas</a></li>
            <li><a href="/"><i class='bx bxs-dashboard icon'></i>Nuestros Doctores</a></li>
            <?php endif; ?>
        </ul>

    </section>
    <!-- End Sidebar -->


<!-- Topbar section -->
<nav class="topbar">
    <button id="toggleSidebar" class="btn btn-primary me-auto d-md-none">
    <i class="bi bi-list"></i>
</button>

    <?php if (isset($ua->sv) && $ua->sv): ?>
        <li class="nav-item dropdown me5">
            <a href="#" class="nav-link dropdown-toggle" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
                <?= isset($ua->username) ? $ua->username : '' ?>
            </a>
            <ul class="dropdown-menu">
                <li><a href="/dashboard" class="dropdown-item btn btn-link">Dashboard</a></li>
                <hr>
                <li><a href="/Session/logout" class="dropdown-item btn btn-link">Cerrar sesión</a></li>
            </ul>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a href="/Session/iniSession" class="nav-link btn btn-link">Iniciar sesión</a>
        </li>
    <?php endif; ?>
</nav>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->



    <?php endif; ?>

<?php
}
?>
