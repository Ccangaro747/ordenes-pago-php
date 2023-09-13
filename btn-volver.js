document.addEventListener("DOMContentLoaded", function () {
    // Obtén una referencia al botón
    var btnVolver = document.getElementById("btn-volver");
    
    // Variable para rastrear el estado del menú
    var menuAbierto = false;
  
    // Agrega un evento de clic al botón
    btnVolver.addEventListener("click", function () {
      // Obtén una referencia al contenedor del menú (por ejemplo, un elemento div)
      var menu = document.getElementById("menu-desplegable");
  
      // Si el menú está cerrado, ábrelo
      if (!menuAbierto) {
        menu.style.display = "block"; // Muestra el menú
        menuAbierto = true; // Actualiza el estado del menú
      } else { // Si el menú está abierto, ciérralo
        menu.style.display = "none"; // Oculta el menú
        menuAbierto = false; // Actualiza el estado del menú
      }
    });
  });
  