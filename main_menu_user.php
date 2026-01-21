<nav class="navbar navbar-expand-lg bg-light shadow-lg">
    <div class="container">
        <a class="navbar-brand" href="index.html">
            <img src="images/logo-color-02.png" class="logo img-fluid" alt="Kind Heart Charity">
            <!--<span>Kind Heart Charity<small>Non-profit Organization</small></span>-->
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="ConLogin.php">Inicio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Noticias.php">Noticias</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Publicaciones.php">Publicaciones</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Trivias.php">Trivias</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Puriskiri.php">PURISKIRI</a>
                </li>

                <?php if ($_SESSION['rol'] == 'Administrador') { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link click-scroll dropdown-toggle" href="#section_5"
                       id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">Admin</a>

                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                        <li><a class="dropdown-item" href="SubirNoticias.php">Noticias</a></li>
                        <li><a class="dropdown-item" href="SubirPublicacion.php">Publicaciones</a></li>
                        <li><a class="dropdown-item" href="EdicionTrivias.php">Trivias</a></li>
                        <li><a class="dropdown-item" href="PuriskiriAdm.php">PURISKIRI</a></li>
                    </ul>
                </li>
                <?php } ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#"
                       id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">Cuenta</a>

                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                        <li><a class="dropdown-item" href="Cuenta.php?id=<?php echo $_SESSION['usuario'];?>">Ir a mi cuenta</a></li>

                        <li>
                            <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal"><p>Cerrar Sesion</p> </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </div>
    </div>
</nav>