<?php
    header('Content-Type: text/html; charset=utf-8');
    require "./PHP/popups.php";
    require './PHP/direcciones.php';
    session_start();
    $config = include('./PHP/config.php');

    if(isset($_SESSION['usuario'])){
        header("location: ConLogin.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Terra ConsCiencia</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <link rel="shortcut icon" href="IMG/Icono.ico" width="50px">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <!--<link rel="stylesheet" href="../assets/CSS/styleSl.css">-->
        <link rel="stylesheet" href="assets/CSS/styleSl.css">
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
                    <p class="numVis1" id="m1"><?php echo $descripciones[0]?></p>
                    <p class="numVis2" id="m2"><?php echo $descripciones[1]?></p>
                    <p class="numVis3" id="m3"><?php echo $descripciones[2]?></p>
                    <p class="numVis4" id="m4"><?php echo $descripciones[3]?></p>
                    <p class="numVis5" id="m5"><?php echo $descripciones[4]?></p>
                    <p class="numVis6" id="m6"><?php echo $descripciones[5]?></p>
                </div>
                <img src="IMG/Ilustracionessolopersonaje-05.svg" alt="">
            </div>
        </div>
        <!--Portada-->
        <div class="portada " style="background-color: rgb(95, 187, 150);">
            <a class="l1">
            </a>
            <div class="l2">
                <a href="https://gaiapacha.org/" target="_blank" style="background-image: url(./IMG/LogoGaia.png); background-size: 100% 100%; width: 180px; height: 70px;  right: 120px;"></a>
                <a href="https://www.solidagro.be/en/home/worldwide/bolivia" target="_blank" style="background-image: url(./IMG/LogoSolidagro.png); background-size: 100% 100%; width: 120px; height: 70px;"></a>
                <a target="_blank" style="background-image: url(./IMG/bELGICA.png); background-size: 100% 100%; width: 220px; height: 120px; margin-top:10px;"></a>
            </div>
        </div>
        <!--Navegacion-->
        <header class="navegador">
            <nav class="contNav">
                <a href="#" class="boton" style="background:rgb(215, 102, 92);border-color:black; border-style:dashed; border-top:none;">
                    INICIO
                </a>
                <a href="NoticiasSl.php" class="boton" style="background: #22764D;">
                    NOTICIAS
                </a>
                <button class="boton" id="abrir" style="background:rgb(238, 37, 117);">
                    INICIAR SESION
                </button>
            </nav>
        </header>
        <!--Iniciar Sesion-->
        <div class="osc" id="opLog">
            <div class="contenedor">
                <div class="login-registro" id="login" >
                    <button class="cerrar"><img id="off" src="IMG/cancelar.png" alt="" width="30px" height="30px"></button>
                    <form action="PHP/loginUsuarioBe.php" method="POST" class="sign-in-form">
                        <h2 class="titulo">INICIAR SESIÓN</h2>
                        <div class="entradas">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Nombre de usuario" name="nombre_usuario" id="" value="<?php echo htmlspecialchars($config['default_user']); ?>">
                        </div>
                        <div class="entradas">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Contraseña" name="clave" id="" value="<?php echo htmlspecialchars($config['default_password']); ?>">
                        </div>
                        <input type="submit" name="" value="Iniciar Sesion" class="btnlg">
                        <p class="ctText">¿NO TIENES CUENTA?<a href="#" id="registro2">REGISTRARSE</a></p>
                    </form>
                    <form action="PHP/registroUsuarioBe.php" method="POST" class="sign-up-form">
                        <h2 class="titulo">REGISTRARSE</h2>
                        <div class="entradas">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Nombre de usuario" name="nombre_usuario" id="" required>
                        </div>
                        <div class="entradas">
                            <i class="fas fa-envelope"></i>
                            <input type="email" placeholder="Correo Electronico" name="correo" id="" required>
                        </div>
                        <div class="entradas">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Contraseña" name="clave" id="" required>
                        </div>
                        <input type="submit" name="" id="" value="Registrarse" class="btnlg">
                        <p class="ctText">¿YA TIENES CUENTA?<a href="#" id="inicio2">INICIAR SESIÓN</a></p>
                    </form>
                </div>
                <div class="paneles">
                    <div class="panel leftPanel">
                        <div class="contenido">
                            <h3>¿YA TIENES CUENTA?</h3>
                            <p>Completa tus datos e inicia sesión para adentrarte a este ecosistema lleno de aventuras y conocimientos.</p>
                            <button class="btnlg" id="inicio">INICIAR SESIÓN</button>
                            <img src="IMG/signin.png" alt="" class="image" style="width: 250px;">
                        </div>
                    </div>
                    <div class="panel rightPanel">
                        <div class="contenido">
                            <h3>¿NO TIENES CUENTA?</h3>
                            <p>Bienvenido/a, al registrarte en este espacio virtual, estarás ingresando a un ecosistema de conocimientos y saberes, que te servirá como herramienta para estar enterado de temáticas urgentes para nuestro planeta</p>
                            <button class="btnlg" id="registro">REGÍSTRATE</button>
                            <img src="IMG/signup.png" alt="" class="image" style="width: 250px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Cuerpo-->
        <div class="cuerpo">
            <div class="main">
                <img src="<?php echo $rutaImagen; ?>" alt="gotitaS" width="100%" height="100%">
            </div>
            <div class="rigth">
                <a href="CalculadoraInicio.html" target="_blank" class="contFlot hdr">
                    <h1>CALCULADORA HÍDRICA</h1><br>
                    <h2>¿Sabes cuál es la huella hídrica que generas?</h2><br>
                    <h2>¡Descúbrelo ahora!</h2>
                    <h2>Haz click para empezar</h2>
                </a>
                <a href="Noticias.php" class="contFlot nt">
                    <img src="<?php echo $rutaImagen2; ?>" alt="" width="100%" height="100%">
                </a>
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
        <script src="JS/scriptLog.js"></script>
    </body>
</html>