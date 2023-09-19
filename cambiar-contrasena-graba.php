<?php 
$usuario = $_POST["usuario"];
$contrasena = $_POST["contrasena"];
$contrasena1 = $_POST["contrasena1"];
$contrasena2 = $_POST["contrasena2"];


if( $contrasena == $contrasena1 ) {
    header("location:cambiar-contrasena.php?error=claveigual");
    die();
}
if( $contrasena1 != $contrasena2 ) {
    header("location:cambiar-contrasena.php?error=clavedistinta");
    die();
}
require("conexion.php");

$sql = "SELECT * FROM usuarios WHERE usuario = '" . $usuario."'  AND 
            clave = '".$contrasena."'";

$query = mysqli_query($conexion,$sql);    
if (!$query) {
    echo "No se pudo ejecutar con exito la consulta en la BD: " .
    mysqli_connect_error();
    exit;
}


if (mysqli_num_rows( $query ) == 0) {
    header("location:cambiar-contrasena.php?error=claveactual");
    die();
}     

$sql = "UPDATE usuarios SET clave = '".$contrasena1."' WHERE usuario = '" . $usuario. "' ";

$query = mysqli_query($conexion,$sql);   
header("location:index.php");
?>