<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inicie sesión para acceder a su cuenta.">
    <link rel="stylesheet" href="styles.scss">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Istok+Web&display=swap" rel="stylesheet">
    <title>ORDENES DE PAGO</title>
    <link rel="icon" href="/assets/logo-2.png" />
</head>
<?php $error = $_GET["error"];?> 
<body>
    <div class="container">
        <img src="./assets/logo2-sombra.png" alt="Logo de Tu Sitio Web">
        <div class="login-form">
            <form action="procesar_login.php" method="post">
                <div class="container-label">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
                </div>
                <div class="container-label">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                </div>
                <input type="submit" id="submit" value="Iniciar sesión">
                <?php if($error == 'error') { ?>
                    <h6 class="parrafo"> Usuario o clave no valido</h6>
                <?php }?>
            </form>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/a3a0d2e0e8.js" crossorigin="anonymous"></script>
</body>
</html>
