<?php
    session_start();
    $_SESSION["desde"] = $_POST["desde"];
    $_SESSION["hasta"] = $_POST["hasta"];
    $_SESSION["importedesde"] = $_POST["importedesde"];
    $_SESSION["importehasta"] = $_POST["importehasta"];
    $_SESSION["proveedor"] = $_POST["proveedor"];

    header("location:index.php");		
	
?>