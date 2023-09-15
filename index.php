<?php
	session_start();
    //Si no estoy logueado me voy a login
    if( !isset( $_SESSION["usuario"])){
    	header("location:login.php");
    }
    //En este punto, me fijo si las variables de filtro no estan inicializadas, si no lo estan, las inicializo
    if( !isset( $_SESSION["desde"])){
    	$_SESSION["desde"] = date('Y-m-d');
    }
    if( !isset( $_SESSION["hasta"])){
    	$_SESSION["hasta"] = date('Y-m-d');
    }
    if( !isset( $_SESSION["importedesde"])){
    	$_SESSION["importedesde"] = 0;
    }
    if( !isset( $_SESSION["importehasta"])){
    	$_SESSION["importehasta"] = 99999999;
    }
    if( !isset( $_SESSION["proveedor"])){
    	$_SESSION["proveedor"] = 0;
    }
  
	// Me conecto a la base de datos
	require("conexion.php");	
  // Hago una consulta a la base para obtener todos los proveedor de la muni
  $sql = "SELECT DISTINCT(razon_social) as nombre,cod_prov FROM orn_ordenes ORDER BY razon_social";
  //Dejo la consulta en una variable que se llama proveedores
  $proveedores = mysqli_query($conexion,$sql);    
  if (!$proveedores) {
        echo "No se pudo ejecutar con exito la consulta en la BD: " .
        mysqli_connect_error();
    exit;
  }

  // Ahora voy a consultar segun los datos del filtro, los registro de la base que coinciden con el criterio de busqueda
  $sql = "SELECT * FROM orn_ordenes 
          WHERE fech_op >= '".$_SESSION["desde"]."' AND 
                fech_op <= '".$_SESSION["hasta"]."' AND 
                importe_total >= '".$_SESSION["importedesde"]."' AND 
                importe_total <= '".$_SESSION["importehasta"]."'  ";
  if($_SESSION["proveedor"] > 0) {
    $sql .= " AND cod_prov = " .$_SESSION["proveedor"];
  }
  $sql .= "  ORDER BY fech_op";
  $ordenes = mysqli_query($conexion,$sql);    
  if (!$ordenes) {
        echo "No se pudo ejecutar con exito la consulta en la BD: " .
        mysqli_connect_error();
    exit;
  }
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>Sistema de Ordenes de pago</title>
    <link rel="icon" href="/imagenes/logo-2.png" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Istok+Web&display=swap"
      rel="stylesheet"
    />
    <link href="DataTables/datatables.min.css" rel="stylesheet" />
    <link
      href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-1.13.6/r-2.5.0/datatables.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"
    />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
      <a class="navbar-brand" href="#">
        <img src="./imagenes/logomuni.png" alt="Logo" />
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item ml-2">
            <a class="nav-link" href="#">
              <i class="fa fa-user"></i>
              <?php echo $_SESSION["usuario"];?>
            </a>
          </li>
          <li class="nav-item dropdown mr-2">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
            </a>
            <div
              class="dropdown-menu dropdown-menu-right"
              aria-labelledby="navbarDropdown"
            >
              <a class="dropdown-item" href="#">
                <i class="fa-solid fa-key"></i>
                Cambiar Contraseña
              </a>
              <a class="dropdown-item" href="cerrar-sesion.php">Salir</a>
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
    <br />
    <div class="container">
      <table
        id="example"
        class="display nowrap dataTable dtr-inline collapsed"
        style="width: 100%"
      >
        <thead>
          <tr>
            <th>Nro OP</th>
            <th>Fecha Op</th>
            <th>Proveedor</th>
            <th>Importe</th>
            <th>Concepto</th>
            <th>Acciones</th>
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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-1.13.6/r-2.5.0/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/0c5da2f650.js" crossorigin="anonymous"></script>
    <script src="DataTables/datatables.min.js"></script>
    <script>
      $(document).ready(function () {
        $("#example").DataTable({
          dom: "Bfrtip",
          processing: true,
          responsive: true,
          language: {
            lengthMenu: "Mostrar _MENU_ registros por pagina",
            search: "Buscar",
            processing: "Procesando... Favor de esperar...",
            loadingRecords: "Cargando registro... Espere por favor...",
            paginate: {
              first: "Primero",
              previous: "Anterior",
              next: "Siguiente",
              last: "Ultimo",
            },
            zeroRecords: "Disculpe, no hay registros",
            info: "Mostrando pagina _PAGE_ de _PAGES_",
            infoEmpty: "Sin registros automáticos",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
          },
        });
      });
    </script>
  </body>
</html>
