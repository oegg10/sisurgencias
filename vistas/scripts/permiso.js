var tabla;

//Función que se ejecuta al inicio
function init() {

    mostrarform(false);
    listar();

}

//Función mostrar formulario
function mostrarform(flag) {

    //limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
    }

}

//Funcion listar
function listar() {

    tabla = $('#tbllistado').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [
            //'copyHtml5',
            //'excelHtml5',
            //'csvHtml5',
            'pdf'
        ],
        "ajax": {

            url: '../ajax/permiso.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }

        },

        "bDestroy": true,
        "iDisplayLength": 10, //paginación
        "order": [
                [0, "desc"]
            ] //Ordenar (columna,orden)

    }).DataTable();

}

init();