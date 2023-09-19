// main.js

const dataTableOptions = {
    // Opciones de DataTables
    lengthMenu: [5, 10, 15, 20, 100, 200, 500],
    columnDefs: [
        { className: "centered", targets: [0, 1, 2, 3, 4, 5, 6] },
        { orderable: false, targets: [5, 6] },
        { searchable: false, targets: [1] }
    ],
    pageLength: 3,
    destroy: true,
    language: {
        lengthMenu: "Mostrar _MENU_ registros por página",
        zeroRecords: "Ningún usuario encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Ningún usuario encontrado",
        infoFiltered: "(filtrados desde _MAX_ registros totales)",
        search: "Buscar:",
        loadingRecords: "Cargando...",
        paginate: {
            first: "Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior"
        }
    }
};

const initDataTable = async () => {
    if (dataTableIsInitialized) {
        dataTable.destroy();
    }

    await listOrders(); // Cambia listUsers a listOrders

    dataTable = $("#datatable_users").DataTable(dataTableOptions);

    dataTableIsInitialized = true;
};

const listOrders = async () => {
    try {
        // Realiza una solicitud AJAX para obtener los datos de las órdenes
        const response = await fetch("obtener_ordenes.php"); // Reemplaza "obtener_ordenes.php" por tu archivo PHP real
        const ordenes = await response.json();

        let content = ``;
        ordenes.forEach((orden, index) => {
            content += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${orden.nro_op}</td>
                    <td>${orden.fech_op}</td>
                    <td>${orden.razon_social}</td>
                    <td>${orden.importe_total}</td>
                    <td>${orden.concepto}</td>
                    <td><button class="btn btn-sm btn-info">Ver</button></td>
                </tr>`;
        });

        // Utiliza el ID "datatable_users" para seleccionar la tabla en el HTML
        const table = $("#datatable_users");
        const tableBody = table.find("tbody"); // Busca el cuerpo de la tabla

        // Limpia el contenido actual y agrega el nuevo contenido
        tableBody.empty().append(content);
    } catch (ex) {
        alert(ex);
    }
};

let dataTable;
let dataTableIsInitialized = false;

window.addEventListener("load", async () => {
    await initDataTable();
});
