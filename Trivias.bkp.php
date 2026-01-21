<?php 
    header('Content-Type: text/html; charset=utf-8');
    include "./PHP/conexionBe.php";
    include "./PHP/popups.php";
    session_start();
    $roles_permitidos = ['Administrador','Usuario'];
    if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
        header("Location: NoticiasSl.php");
        session_destroy();
        die();
    } else {
        if ($_SESSION['rol'] == 'Administrador') {
            header("Location: TriviasAdm.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Trivias</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <link rel="shortcut icon" href="IMG/Icono.ico" width="50px">
        <link rel="stylesheet" href="assets/CSS/styleTr.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Belanosima&family=Pacifico&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
    </head>
    <body>
        <!--Popup-->
        <input type="checkbox" id="cerrar">
        <label for="cerrar" id="btnCerrar">x</label>
        <div class="modal" id="fnd">
            <div class="contenido" id="cont">
                <div class="descr">
                    <p class="numVis1" id="m1"><?php echo $descripciones[18]?></p>
                    <p class="numVis2" id="m2"><?php echo $descripciones[19]?></p>
                    <p class="numVis3" id="m3"><?php echo $descripciones[20]?></p>
                    <p class="numVis4" id="m4"><?php echo $descripciones[21]?></p>
                    <p class="numVis5" id="m5"><?php echo $descripciones[22]?></p>
                    <p class="numVis6" id="m6"><?php echo $descripciones[23]?></p>
                </div>
                <img src="IMG/Ilustracionessolopersonaje-02.svg" alt="">
            </div>
        </div>
        <!--Confirmacion-->
        <div class="confir" id="fndCf">
            <div class="vent" id="vent">
                <p>¿Desea cerrar sesión?</p>
                <div class="botonesCf">
                    <a class="btnConf" href="PHP/cerrar_sesion.php">Sí</a>
                    <a class="btnConf" href="javascript:cierraConf()">NO</a>
                </div>
            </div>
        </div>
        <!--Portada-->
        <div class="portada">
            <a class="l1">
            </a>
            <div class="l2">
                <a href="https://gaiapacha.org/" target="_blank" style="background-image: url(./IMG/LogoGaia.png); background-size: 100% 100%; width: 180px; height: 70px;  right: 120px;"></a>
                <a href="https://www.solidagro.be/en/home/worldwide/bolivia" target="_blank" style="background-image: url(./IMG/LogoSolidagro.png); background-size: 100% 100%; width: 120px; height: 70px;"></a>
                <a target="_blank" style="background-image: url(./IMG/bELGICA.png); background-size: 100% 100%; width: 220px; height: 120px; margin-top:10px;"></a>
            </div>
        </div>
        <!--Navegacion-->
        <nav class="navegador">
            <ul class="contNav">
                <a href="ConLoginAdm.php" class="boton" style="background:rgb(215, 102, 92); ">
                    <li>INICIO</li>
                </a>
                <a href="Noticias.php" class="boton" style="background:rgb(239, 170, 86);border-color: black;">
                    <li>NOTICIAS</li>
                </a>
                <a href="Publicaciones.php" class="boton" style="background:rgb(125, 192, 207); width: 22%;">
                    <li>PUBLICACIONES</li>
                </a>
                <a href="Trivias.php" class="boton" style="background: #22764D; border-style:dashed; border-top:none; border-color: black;">
                    <li>TRIVIAS</li>
                </a>
                <a href="javascript:abreCt()" class="boton" style="background:rgb(238, 37, 117); display: flex; justify-content: space-evenly;">
                    <li>CUENTA&nbsp;&nbsp;</li>
                    <!--Cuenta Desplegable-->
                    <img class="abrirPerfil" id="giro" src="IMG/botArrow.svg" width="22px" height="22px" alt="">
                    <a href="javascript:cierraCt()" class="cierra" id="cl"></a>
                    <div class="desp" id="despCt">
                        <a href="Cuenta.php" class="btnCtDesp">
                            <i class="fas fa-user"></i>
                            <p>Ir a mi cuenta</p>
                        </a>
                        <div class="btnCtDesp">
                            <i class="fas fa-question"></i>
                            <p>Ayuda</p>
                        </div>
                        <a href="javascript:abreConf()" class="btnCtDesp">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Cerrar Sesion</p>
                        </a>
                    </div>
                </a>
            </ul>
        </nav>
        <!--Cuerpo-->
        <div class="cuerpo">
            <div class="contTriv">
                <div class="main">
                    <div class="trivs">
                        <div class="cajaExt">
                            <div class="cajaInt">
                                <img src="IMG/notebook.png" alt="">
                                <p>Prueba tu conocimiento y gana puntos con este sencillo test.</p>
                                <a href="J2.php" class="btnTr">
                                    Ir Ahora
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                            <div class="cajaInt">
                                <img src="IMG/037-tierra.png" alt="">
                                <p>Encuentra los pares y obten puntos!!!</p>
                                <a href="J1.php" class="btnTr">
                                    Ir Ahora
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                            <div class="cajaInt">
                                <img src="IMG/001-avion-de-papel.png" alt="">
                                <p>Aprende algo nuevo, rinde un pequeño test y gana puntos.</p>
                                <a href="J3.php" class="btnTr">
                                    Ir Ahora
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="cajaExt">
                            <div class="cajaInt">
                                <img src="IMG/002-estera.png" alt="">
                                <p>Podras adivinar la palabra correcta?</p>
                                <a href="J4.php" class="btnTr">
                                    Ir Ahora
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                            <div class="cajaInt">
                                <img src="IMG/005-libro.png" alt="">
                                <p>Ordena, elige sabiamente y gana!!!</p>
                                <a href="J5.php" class="btnTr">
                                    Ir Ahora
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                            <div class="cajaInt">
                                <img src="IMG/008-prueba.png" alt="">
                                <p>¡Intenta encontrar todas las palabras!</p>
                                <a href="SopaLetras/index.html" class="btnTr">
                                    Ir Ahora
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rigth">
                    <div class="rank">
                        <p>RANKING:</p>
                        <div class="dat">
                            <p style="margin-left: 5%;">#</p>
                            <p style="margin-left: 6%;">Perfil</p>
                            <p style="margin-left: 15%;">Nombre</p>
                            <p style="margin-left: 20%;">Puntos</p>
                        </div>
                        <div id="rankingTable"></div>
                    </div>
                </div>
        </div>
        <!--Pie-->
        <footer class="pie">
            <div class="info">
            <div class="infoGaia">
                <p>
                    <ul class="ct">
                        <b>GAIA PACHA</b>
                        <li>Celular: 76957456</li>
                        <li>E-mail: <a style="text-decoration: underline; color: rgb(125, 127, 255);" href="mailto:gaiapacha@gaiapacha.org">gaiapacha@gaiapacha.org</a></li>
                    </ul>
                </p>
            </div>
            <div class="infoSolid">
                <p>
                    <ul class="ct">
                        <b>SOLIDAGRO</b>
                        <li>Celular: +32 3 777 20 15</li>
                        <li>E-mail: <a style="text-decoration: underline; color: rgb(125, 127, 255);" href="mailto:info@solidagro.be">info@solidagro.be</a></li>
                    </ul>
                </p>
            </div>
            </div>
            <div class="contacto">
                <p>REDES SOCIALES:</p>
                <a href="https://www.facebook.com/gaiapacha?mibextid=ZbWKwL"><img src="IMG/facebook.png" alt="facebook" width="50px" height="50px"></a>
                <a href="https://instagram.com/gaiapacha?igshid=YmMyMTA2M2Y="><img src="IMG/instagram.png" alt="instagram" width="50px" height="50px"></a>
                <a href="https://www.linkedin.com/company/fundaci%C3%B3n-gaia-pacha/"><img src="IMG/linkedin.png" alt="linkedin" width="50px" height="50px"></a>
            </div>
        </footer>
        <script src="JS/scriptCt.js"></script>
        <script src="JS/scriptTr.js"></script>
        <script src="JS/rank.js"></script>
    </body>
</html>