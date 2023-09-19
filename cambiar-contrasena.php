<?php
    session_start();
    if (!isset($_SESSION["usuario"])) {
        header("location: login.php");
        exit; // Salir para evitar la ejecución adicional del código.
    }
?>    
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inicie sesión para acceder a su cuenta.">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Istok+Web&display=swap" rel="stylesheet">
    <title>CAMBIAR CONTRASEÑA</title>
    <link rel="icon" href="/assets/logo-2.png" />
</head>
<?php $error = $_GET["error"];?> 
<body>
    <div class="container">
        <img src="./assets/logo2-sombra.png" alt="Logo de Tu Sitio Web">
        <div class="login-form">
            <form action="cambiar-contrasena-graba.php" method="post">
                <div class="container-label">
                    <i class="fa-solid fa-user"></i>
                    <p><?php echo $_SESSION['user'];?></p>
                    <input type="hidden" id="usuario" name="usuario" value="<?php echo $_SESSION['user'];?>" placeholder="Usuario">
                </div>
                <div class="container-label">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña actual" required>
                </div>
                <div class="container-label">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="contrasena1" name="contrasena1" placeholder="Nueva contraseña" required>
                </div>
                <div class="container-label">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="contrasena2" name="contrasena2" placeholder="Repita contraseña nueva" required>
                </div>
                <input type="submit" id="submit" value="Cambiar contraseña">
                <?php if($error == 'claveigual') { ?>
                    <h6 class="parrafo"> Ud. puso la misma contraseña actual</h6>
                <?php }?>
                <?php if($error == 'clavedistinta') { ?>
                    <h6 class="parrafo"> No coicinden las contraseñas</h6>
                <?php }?>
                <?php if($error == 'claveactual') { ?>
                    <h6 class="parrafo"> Clave actual incorrecta</h6>
                <?php }?>
            </form>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/a3a0d2e0e8.js" crossorigin="anonymous"></script>
</body>
</html>