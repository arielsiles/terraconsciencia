<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    require "./PHP/preguntasTest.php";
    include "./PHP/popups.php";
    $roles_permitidos = ['Administrador','Usuario'];
    if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
        header("Location: SinLogin.php");
        session_destroy();
        die();
    } else {
        if ($_SESSION['rol'] == 'Administrador') {
            header("Location: J2Adm.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Test Conciencia Ambiental</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <link rel="shortcut icon" href="IMG/Icono.ico" width="50px">
        <link rel="stylesheet" href="assets/CSS/styleJgs.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Belanosima&family=Pacifico&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
    </head>
    <body>
        <!--Popup-->
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
                <a href="Trivias.php" class="boton" style="background: #22764D;border-style:dashed; border-top:none; border-color: black;">
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
            <div class="lado">
                <a href="Trivias.php" class="btnBack">
                    <i class="fas fa-arrow-circle-left"></i>
                    Volver Atras
                </a>
            </div>
            <div class="posicion">
                <div class="ladosForm">
                    <img src="IMG/estres.png" alt="">
                </div>
                <div class="contTest">
                    <div id="test">
                    <h1>Test de Conocimientos</h1>
                        <form id="formulario">
                            <h2>Pregunta 1</h2>
                            <h3><?php echo $pregunta[0]?></h3>
                            <div class="rs">
                                <label>
                                    <input type="radio" name="p1" value="a">
                                    <?php echo $opc1[0]?>
                                </label>
                                <label>
                                    <input type="radio" name="p1" value="b">
                                    <?php echo $opc2[0]?>
                                </label>
                                <label>
                                    <input type="radio" name="p1" value="c">
                                    <?php echo $opc3[0]?>
                                </label>
                            </div>
                            <br>
                            <h2>Pregunta 2</h2>
                            <h3><?php echo $pregunta[1]?></h3>
                            <div class="rs">
                                <label>
                                    <input type="radio" name="p2" value="a">
                                    <?php echo $opc1[1]?>
                                </label>
                                <label>
                                    <input type="radio" name="p2" value="b">
                                    <?php echo $opc2[1]?>
                                </label>
                                <label>
                                    <input type="radio" name="p2" value="c">
                                    <?php echo $opc3[1]?>
                                </label>
                            </div>
                            <br>
                            <h2>Pregunta 3</h2>
                            <h3><?php echo $pregunta[2]?></h3>
                            <div class="rs">
                                <label>
                                    <input type="radio" name="p3" value="a">
                                    <?php echo $opc1[2]?>
                                </label>
                                <label>
                                    <input type="radio" name="p3" value="b">
                                    <?php echo $opc2[2]?>
                                </label>
                                <label>
                                    <input type="radio" name="p3" value="c">
                                    <?php echo $opc3[2]?>
                                </label>
                            </div>
                            <br>
                            <h2>Pregunta 4</h2>
                            <h3><?php echo $pregunta[3]?></h3>
                            <div class="rs">
                                <label>
                                    <input type="radio" name="p4" value="a">
                                    <?php echo $opc1[3]?>
                                </label>
                                <label>
                                    <input type="radio" name="p4" value="b">
                                    <?php echo $opc2[3]?>
                                </label>
                                <label>
                                    <input type="radio" name="p4" value="c">
                                    <?php echo $opc3[3]?>
                                </label>
                            </div>
                            <br>
                            <h2>Pregunta 5</h2>
                            <h3><?php echo $pregunta[4]?></h3>
                            <div class="rs">
                                <label>
                                    <input type="radio" name="p5" value="a">
                                    <?php echo $opc1[4]?>
                                </label>
                                <label>
                                    <input type="radio" name="p5" value="b">
                                    <?php echo $opc2[4]?>
                                </label>
                                <label>
                                    <input type="radio" name="p5" value="c">
                                    <?php echo $opc3[4]?>
                                </label>
                            </div>
                            <br>
                            <h2>Pregunta 6</h2>
                            <h3><?php echo $pregunta[5]?></h3>
                            <div class="rs">
                                <label>
                                    <input type="radio" name="p6" value="a">
                                    <?php echo $opc1[5]?>
                                </label>
                                <label>
                                    <input type="radio" name="p6" value="b">
                                    <?php echo $opc2[5]?>
                                </label>
                                <label>
                                    <input type="radio" name="p6" value="c">
                                    <?php echo $opc3[5]?>
                                </label>
                            </div>
                            <br>
                            <h2>Pregunta 7</h2>
                            <h3><?php echo $pregunta[6]?></h3>
                            <div class="rs">
                                <label>
                                    <input type="radio" name="p7" value="a">
                                    <?php echo $opc1[6]?>
                                </label>
                                <label>
                                    <input type="radio" name="p7" value="b">
                                    <?php echo $opc2[6]?>
                                </label>
                                <label>
                                    <input type="radio" name="p7" value="c">
                                    <?php echo $opc3[6]?>
                                </label>
                            </div>
                            <br>
                            <h2>Pregunta 8</h2>
                            <h3><?php echo $pregunta[7]?></h3>
                            <div class="rs">
                                <label>
                                    <input type="radio" name="p8" value="a">
                                    <?php echo $opc1[7]?>
                                </label>
                                <label>
                                    <input type="radio" name="p8" value="b">
                                    <?php echo $opc2[7]?>
                                </label>
                                <label>
                                    <input type="radio" name="p8" value="c">
                                    <?php echo $opc3[7]?>
                                </label>
                            </div>
                            <br>
                            <h2>Pregunta 9</h2>
                            <h3><?php echo $pregunta[8]?></h3>
                            <div class="rs">
                                <label>
                                    <input type="radio" name="p9" value="a">
                                    <?php echo $opc1[8]?>
                                </label>
                                <label>
                                    <input type="radio" name="p9" value="b">
                                    <?php echo $opc2[8]?>
                                </label>
                                <label>
                                    <input type="radio" name="p9" value="c">
                                    <?php echo $opc3[8]?>
                                </label>
                            </div>
                            <br>
                            <h2>Pregunta 10</h2>
                            <h3><?php echo $pregunta[9]?></h3>
                            <div class="rs">
                                <label>
                                    <input type="radio" name="p10" value="a">
                                    <?php echo $opc1[9]?>
                                </label>
                                <label>
                                    <input type="radio" name="p10" value="b">
                                    <?php echo $opc2[9]?>
                                </label>
                                <label>
                                    <input type="radio" name="p10" value="c">
                                    <?php echo $opc3[9]?>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="ladosForm" style="align-items: start;">
                    <img src="IMG/pregunta.png" alt="">
                </div>
            </div>
            <div class="lado" style="flex-direction: column; align-items:center; justify-content: start;">
                <button type="button" onclick="calcularResultado()" class="btnBack" style="cursor: pointer;">Calcular Resultado</button>
                <div id="resultado" style="display: none;">
                    <h2>Resultado</h2>
                    <p id="puntuacion"></p>
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
            <script src="JS/scriptCt.js"></script>
            <script src="JS/scriptCl.js"></script>
            <script src="PHP/calcularResultado.php"></script>
        </footer>
    </body>
</html>