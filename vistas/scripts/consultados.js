var tabla;

//Función que se ejecuta al inicio
function init() {

    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {
        egreso(e);
    })

}

//Función limpiar
function limpiar() {

    $("#idpaciente").val("");
    $("#nombre").val("");
    $("#fechaegreso").val("");
    $("#altapor").val("");
    $("#otro").val("");

}

//Función mostrar formulario
function mostrarform(flag) {

    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        //$("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        //$("#btnagregar").show();
    }

}

//Función cancelarform
function cancelarform() {

    limpiar();
    mostrarform(false);

}


//Funcion listar
function listar() {

    tabla = $('#tbllistado').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [
            //'copyHtml5',
            'excelHtml5',
            //'csvHtml5',
            //'pdf'
        ],
        "ajax": {

            url: '../ajax/consultados.php?op=listar',
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

//Función para guardar o editar
function egreso(e) {

    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/consultados.php?op=egreso",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });

    limpiar();

}

//Funcion para volver la condición de egresado a NO egresado
function noegreso(idpaciente) {
    bootbox.confirm("¿Está seguro de anular el egreso del paciente?", function(result) {
        if (result) {
            $.post("../ajax/consultados.php?op=noegreso", { idpaciente: idpaciente }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

function mostrar(idpaciente) {

    $.post("../ajax/consultados.php?op=mostrar", { idpaciente: idpaciente }, function(data, status) {

        data = JSON.parse(data);
        mostrarform(true);

        $("#idpaciente").val(data.idpaciente);
        $("#nombre").val(data.nombre);
        //$("#fechaegreso").val(data.fechaegreso);
        //$("#altapor").val(data.altapor);
        //$("#otro").val(data.otro);

    })

}

//Funcion para incorporar al paciente a la sala
function atendido(idpaciente) {
    bootbox.confirm("¿Está seguro de meter al paciente a consulta?", function(result) {
        if (result) {
            $.post("../ajax/consultados.php?op=atendido", { idpaciente: idpaciente }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

//Funcion para desincorporar al paciente de la sala de consulta
function noatendido(idpaciente) {
    bootbox.confirm("¿Está seguro de devolver al paciente a la sala de espera?", function(result) {
        if (result) {
            $.post("../ajax/consultados.php?op=noatendido", { idpaciente: idpaciente }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

init();