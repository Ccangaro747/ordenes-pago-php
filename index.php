<?php
    session_start();

    // Si el usuario no está logueado, redirigirlo a la página de inicio de sesión.
    if (!isset($_SESSION["usuario"])) {
        header("location: login.php");
        exit; // Salir para evitar la ejecución adicional del código.
    }

    // Inicializar variables de filtro si no están inicializadas.
    if (!isset($_SESSION["desde"])) {
        $_SESSION["desde"] = date('Y-m-d');
    }
    if (!isset($_SESSION["hasta"])) {
        $_SESSION["hasta"] = date('Y-m-d');
    }
    if (!isset($_SESSION["importedesde"])) {
        $_SESSION["importedesde"] = 0;
    }
    if (!isset($_SESSION["importehasta"])) {
        $_SESSION["importehasta"] = 99999999;
    }
    if (!isset($_SESSION["proveedor"])) {
        $_SESSION["proveedor"] = 0;
    }

    // Conexión a la base de datos.
    require("conexion.php");

    // Consulta para obtener todos los proveedores de la municipalidad.
    $sql = "SELECT DISTINCT(razon_social) as nombre, cod_prov FROM orn_ordenes ORDER BY razon_social";

    // Ejecutar la consulta y almacenar el resultado en $proveedores.
    $proveedores = mysqli_query($conexion, $sql);

    // Verificar si la consulta se ejecutó correctamente.
    if (!$proveedores) {
        echo "No se pudo ejecutar con éxito la consulta en la BD: " . mysqli_connect_error();
        exit;
    }

    // Consulta para obtener registros que coincidan con los filtros.
    $sql = "SELECT * FROM orn_ordenes 
            WHERE fech_op >= '" . $_SESSION["desde"] . "' AND 
                  fech_op <= '" . $_SESSION["hasta"] . "' AND 
                  importe_total >= '" . $_SESSION["importedesde"] . "' AND 
                  importe_total <= '" . $_SESSION["importehasta"] . "'  ";

    // Agregar condición de filtro por proveedor si se seleccionó uno.
    if ($_SESSION["proveedor"] > 0) {
        $sql .= " AND cod_prov = " . $_SESSION["proveedor"];
    }

    $sql .= "  ORDER BY fech_op";

    // Ejecutar la consulta y almacenar el resultado en $ordenes.
    $ordenes = mysqli_query($conexion, $sql);

    // Verificar si la consulta se ejecutó correctamente.
    if (!$ordenes) {
        echo "No se pudo ejecutar con éxito la consulta en la BD: " . mysqli_connect_error();
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema de Pago</title>
    <link rel="icon" href="/imagenes/logo-2.png">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Istok+Web&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="/imagenes/logomuni.png" alt="Logo Municipalidad">
        </a>
        <!-- Botón del menú hamburguesa -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION["usuario"];?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="usuarioDropdown">
                        <a class="dropdown-item" href="#">Cambiar Contraseña</a>
                        <a class="dropdown-item" href="#">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div id="contenedor-filtro">
      <div class="contenedor-button">
        <button id="btn-volver">
          <i class="fa fa-arrow-left"></i>
          Volver
        </button>
      </div>
      <h2> <?php echo $_SESSION["entinom"];?></h2>
      <form id="filterForm" action="procesar_filtro.php" method="post">
        <label for="startDate" id="startDate-container"
          >Fecha desde:
          <input type="date" id="startDate" name="desde" value="<?php echo $_SESSION['desde'];?>" required
        /></label>
        <label for="endDate" id="endDate-container"
          >Fecha hasta: <input type="date" id="endDate" name="hasta" value="<?php echo $_SESSION['hasta'];?>" required
        /></label>
        <label for="amountFrom"
          >Importe desde:
          <input type="number" id="amountFrom" name="importedesde" min="0" value="<?php echo $_SESSION['importedesde'];?>"
        /></label>
        <label for="amountTo"
          >Importe hasta:
          <input type="number" id="amountTo" name="importehasta" min="0" value="<?php echo $_SESSION['importehasta'];?>"
        /></label>
        <label for="provider"
          >Proveedor:
          <select id="provider" name="proveedor">            
            <option value="0" > - TODOS LOS PROVEEDORES --</option>            
            <?php //Recorro toda la consulta obtenida 
              while ($prov = mysqli_fetch_array($proveedores)) {
                // Pongo como value el codigo de proveedor, como texto a mostrar el nombre del proveedor  ?>
                <option value="<?php echo $prov['cod_prov'];?>" 
                   <?php // Aca me fijo si el nro de proveedor coincide con el proveedor del filtro, lo muestro como seleccionado
                       if($prov['cod_prov'] == $_SESSION["proveedor"]) {
                            echo 'selected';
                     } ?>
                >
                <?php echo $prov['nombre'];?></option>
            <?php }?>
          </select>
        </label>
        <div id="boton-filtrar">
          <button type="submit">Filtrar</button>
        </div>
      </form>
    </div>

    <div class="container my-4">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <table id="datatable_users" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="centered">#</th>
                            <th class="centered">Nro op</th>
                            <th class="centered">Fecha op</th>
                            <th class="centered">Proveedor</th>
                            <th class="centered">Importe</th>
                            <th class="centered">Concepto</th>
                            <th class="centered">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            //Recorro toda la consulta de ordenes de pago 
                            while ($orden = mysqli_fetch_array($ordenes)) {?>
                                <tr>
                                    <td><?php echo $orden['nro_op'];?></td>
                                    <td><?php echo $orden['fech_op'];?></td>
                                    <td><?php echo $orden['razon_social'];?></td>
                                    <td><?php echo $orden['importe_total'];?></td>
                                    <td><?php echo $orden['concepto'];?></td>
                                    <td><button class="btn btn-sm btn-info">Ver</button></td>
                                </tr>
                            <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Custom JS -->

    <script src="main.js"></script>

    <!-- Bootstrap-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
      crossorigin="anonymous"
    ></script>

    <!-- jQuery -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- DataTable -->

    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    <!-- Font Awesome Kit (Iconos) -->
    <script
      src="https://kit.fontawesome.com/0c5da2f650.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
