new DataTable('#example');

// Define un arreglo de datos para la "Columna 5"
const columna5Data = [
  "Dato 1",
  "Dato 2",
  "Dato 3",
  // Agrega más datos según sea necesario, asegurándote de que haya un dato para cada fila en la tabla
];

// Obtén una referencia a los elementos del formulario
const startDateInput = document.getElementById("startDate");
const endDateInput = document.getElementById("endDate");
const amountFromInput = document.getElementById("amountFrom");
const amountToInput = document.getElementById("amountTo");
const providerSelect = document.getElementById("provider");
const filteredDataContainer = document.getElementById("filteredData");

// Resto del código...

// Función para filtrar los datos
function filterData() {
  // Obtén los valores ingresados en el formulario
  const startDate = new Date(startDateInput.value);
  const endDate = new Date(endDateInput.value);
  const amountFrom = parseFloat(amountFromInput.value) || 0;
  const amountTo = parseFloat(amountToInput.value) || Infinity;
  const selectedProvider = providerSelect.value;

  // Obtén todas las filas de la tabla
  const tableRows = document.querySelectorAll(".tabla-responsiva table tbody tr");

  // Itera sobre las filas y muestra/oculta según los criterios de filtrado
  tableRows.forEach((row, index) => {
    const rowData = row.querySelectorAll("td");
    const fecha = new Date(rowData[1].textContent); // Suponiendo que la fecha está en la segunda columna
    const importe = parseFloat(rowData[2].textContent);

    // Verifica si la fecha está dentro del rango seleccionado, el importe está en el rango
    // y el proveedor coincide
    if (
      fecha >= startDate &&
      fecha <= endDate &&
      importe >= amountFrom &&
      importe <= amountTo &&
      rowData[3].textContent === selectedProvider
    ) {
      row.style.display = ""; // Muestra la fila
      // Agrega el dato de la "Columna 5" a la fila
      rowData[4].textContent = columna5Data[index]; // Usa el índice para obtener el dato correspondiente
    } else {
      row.style.display = "none"; // Oculta la fila
    }
  });
}

// Llama a la función de filtrado inicialmente para mostrar todos los datos
filterData();


