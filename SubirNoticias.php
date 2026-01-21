<?php
    header('Content-Type: text/html; charset=utf-8');
    require "./PHP/popups.php";
    session_start();
    $roles_permitidos = ['Administrador'];
    if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
        header("Location: ConLogin.php");
    }
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
        <title>Edicion</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <link rel="shortcut icon" href="IMG/Icono.ico" width="50px">
        <link rel="stylesheet" href="assets/CSS/styleEdicion.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
</head>
<body>
    <div class="contenedorNt">
        <form action="PHP/subir_noticias.php" method="post" class="subida" enctype="multipart/form-data">
            <h2>Subir una Noticia:</h2>
            <h3>Ingrese el titulo</h3>
            <input type="text" name="titulo" maxlength="255" style="width: 550px;" required>
            <h3>Suba la imagen</h3>
            <label for="imagenNt" style="cursor: pointer;" >
                <img src="./IMG/imagenCamara.jpg" alt="" width="156px" height="110px" id="previewImgNt">
            </label>
            <input type="file" accept="image/*" name="imagenNoticia" id="imagenNt" style="display: none;" onchange="javascript:previewImage(event, '#previewImgNt')" required >
            <h3>Haga una breve descripcion</h3>
            <textarea name="descripcion" id="" cols="30" rows="6" maxlength="250" required></textarea>
            <h3>Inserte la informacion completa de la noticia</h3>
            <textarea name="completa" id="" cols="70" rows="10" maxlength="10000" required></textarea>
            <input type="submit" style="display: none;" id="subir" >
            <label class="btnSubir" for="subir">Subir Noticia</label>
        </form>

        <form action="PHP/subir_noticias.php" method="post" class="reelevante">
            <h3>Inserte el id de la noticia a mostrarse como reelevante:</h3>
            <input type="text" name="idNot" >
            <input type="submit">
        </form>

        <h2>Edita los mensajes de los popups: </h2>
        <h3>Maximo 130 caracteres.</h3>
        <form action="./PHP/subidaCl.php" method="POST" class="popups">
            <p>Modal 1:</p>
            <input type="text" class="modal" name="modif7" placeholder="<?php echo $descripciones[6]?>">
            <p>Modal 2:</p>
            <input type="text" class="modal" name="modif8" placeholder="<?php echo $descripciones[7]?>">
            <p>Modal 3:</p>
            <input type="text" class="modal" name="modif9" placeholder="<?php echo $descripciones[8]?>">
            <p>Modal 4:</p>
            <input type="text" class="modal" name="modif10" placeholder="<?php echo $descripciones[9]?>">
            <p>Modal 5:</p>
            <input type="text" class="modal" name="modif11" placeholder="<?php echo $descripciones[10]?>">
            <p>Modal 6:</p>
            <input type="text" class="modal" name="modif12" placeholder="<?php echo $descripciones[11]?>">
            <input type="submit" value="Modificar" id="subModPpNt" style="display: none;">
            <label for="subModPpNt" class="botonPortada" ><i class="fas fa-thumbs-up"></i></label>
        </form>

        <!--<a class="return" href="NoticiasAdm.php">Volver</a>-->
        <a class="return" href="ConLogin.php">Volver</a>
    </div>
    <script src="./JS/preview.js"></script>
</body>
</html>