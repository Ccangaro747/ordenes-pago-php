// Obtén una referencia a los elementos del formulario
const startDateInput = document.getElementById("startDate");
const endDateInput = document.getElementById("endDate");
const amountFromInput = document.getElementById("amountFrom");
const amountToInput = document.getElementById("amountTo");
const providerSelect = document.getElementById("provider");
const filteredDataContainer = document.getElementById("filteredData");

// Agrega un evento de escucha al botón de filtrar
document.querySelector("button[type='button']").addEventListener("click", filterData);

// Función para filtrar los datos
function filterData() {
  // Obtén los valores ingresados en el formulario
  const startDate = startDateInput.value;
  const endDate = endDateInput.value;
  const amountFrom = parseFloat(amountFromInput.value) || 0;
  const amountTo = parseFloat(amountToInput.value) || Infinity;
  const selectedProvider = providerSelect.value;

  // Realiza el filtrado de datos aquí
  // Puedes usar JavaScript para iterar sobre las filas de la tabla y mostrar/ocultar según los criterios de filtrado

  // Ejemplo: Filtrar datos por rango de fechas y proveedor
  const tableRows = document.querySelectorAll(".tabla-responsiva table tbody tr");
  tableRows.forEach((row) => {
    const rowData = row.querySelectorAll("td");
    const fecha = rowData[2].textContent; // Suponiendo que la fecha está en la tercera columna

    // Verifica si la fecha está dentro del rango seleccionado y el proveedor coincide
    if (fecha >= startDate && fecha <= endDate && rowData[4].textContent === selectedProvider) {
      row.style.display = ""; // Muestra la fila
    } else {
      row.style.display = "none"; // Oculta la fila
    }
  });

  // Puedes personalizar esta función de filtrado según tus necesidades específicas
}

// Llama a la función de filtrado inicialmente para mostrar todos los datos
filterData();
