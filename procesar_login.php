<?php
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];
    require("conexion.php");	
    
    $sql = "SELECT u.*, e.nombre as entinom FROM usuarios u LEFT JOIN entidades e ON u.perfil = e.codigo
            WHERE u.usuario = '" . $usuario."'  AND 
            u.clave = '".$contrasena."'";

    $query = mysqli_query($conexion,$sql);    
    if (!$query) {
        echo "No se pudo ejecutar con exito la consulta en la BD: " .
        mysqli_connect_error();
    exit;
    }


    if (mysqli_num_rows( $query ) > 0) {
        //echo "Las pass son iguales";
        session_start();
        $dato = mysqli_fetch_assoc( $query );
        $_SESSION["usuario"] = $dato["nombre"];
        $_SESSION["user"]    = $dato["usuario"];
        $_SESSION["entidad"] = $dato["perfil"];
        $_SESSION["entinom"] = $dato['entinom']; 

        /*$sql = "SELECT * FROM entidades WHERE codigo = '" . $dato["perfil"]. "' ";

        $query = mysqli_query($conexion,$sql);   
        if (mysqli_num_rows( $query ) > 0) {
            $dato = mysqli_fetch_assoc( $query );
            $_SESSION["entinom"] = $dato['nombre']; 
            }
            else 
            {
            $_SESSION["entinom"] = 'INEXISTENTE';
        }*/
        header("location:index.php");		
	} else { 
		header("location:login.php?error=error");
	}
    
?>
