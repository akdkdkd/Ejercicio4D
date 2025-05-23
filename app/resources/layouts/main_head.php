<?php
    function setHeader($args){
        $ua = as_object( $args->ua );

        
?>
<!DOCTYPE html>
<html lang="es">
<head>    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?=CSS?>bootstrap.css">
    <!-- <link rel="stylesheet" type="text/css" href="app.css"> -->  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <title><?=$args->title?></title>
    <style>
        body {
            color: #888;
            background-color : #CCC;
        }
    </style> 
</head>
<body>    <!-- Sidebar / barra lateral -->
    <section id="sidebar" class="sidebar">
        <a href="#" class="brand"><i class='bx bx-plus-medical' ></i>Purple label</a>
        <ul class="side-menu">
            <li><a href="#"><i class='bx bxs-dashboard icon' ></i>Dashboard</a></li>
            <li><a href="/lista"><i class='bx bx-list-ul icon' ></i>lista</a></li>
            <li><a href="#"><i class='bx bxs-report icon' ></i>formulario</a></li>
            <li><a href="#"><i class='bx bx-detail icon' ></i>Detalles</a></li>
        </ul>
    </section>
    <!-- End Sidebar -->

    <!-- Topbar section -->
    <nav class="topbar">
<?php if( isset( $ua->sv ) && $ua->sv ) :?>
                        <li class="nav-item dropdown me5">
                            <a href="#" class="nav-link dropdown-toggle" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?=isset($ua->username) ? $ua->username : ''?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/Session/logout" 
                                        class="dropdown-item btn btn-link">
                                    Cerrar sessión
                                </a></li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="/Session/iniSession" class="nav-link btn btn-link">
                                Iniciar sesión
                            </a>
                        </li>
                    <?php endif ?>
    </nav>
<?php
}
