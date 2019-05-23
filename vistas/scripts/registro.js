var tabla;

//Función que se ejecuta al inicio
function init() {

    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    })

}

//Función limpiar
function limpiar() {

    $("#idpaciente").val("");
    $("#nombre").val("");
    $("#edad").val("");
    $("#num_gesta").val("");
    $("#diagnostico").val("");
    $("#num_segpop").val("");
    $("#sala").val("");
    $("#medico").val("");
    $("#idusuario").val("");
    $("#turno").val("");
    $("#observaciones").val("");

}

//Función mostrar formulario
function mostrarform(flag) {

    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
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

            url: '../ajax/registro.php?op=listar',
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
function guardaryeditar(e) {

    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/registro.php?op=guardaryeditar",
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

function mostrar(idpaciente) {

    $.post("../ajax/registro.php?op=mostrar", { idpaciente: idpaciente }, function(data, status) {

        data = JSON.parse(data);
        mostrarform(true);

        $("#nombre").val(data.nombre);
        $("#edad").val(data.edad);
        $("#sexo").val(data.sexo);
        //$("#sexo").selectpicker('refresh');
        $("#embarazo").val(data.embarazo);
		//$("#embarazo").selectpicker('refresh');
        $("#num_gesta").val(data.num_gesta);
        $("#diagnostico").val(data.diagnostico);
        $("#num_segpop").val(data.num_segpop);
        $("#sala").val(data.sala);
        $("#medico").val(data.medico);
        $("#turno").val(data.turno);
        //$("#turno").selectpicker('refresh');
        $("#observaciones").val(data.observaciones);
        $("#idpaciente").val(data.idpaciente);

    })

}

//Funcion para incorporar al paciente a la sala
function atendido(idpaciente) {
    bootbox.confirm("¿Está seguro de ingresar al paciente a consulta?", function(result){
        if (result) {
            $.post("../ajax/registro.php?op=atendido", { idpaciente : idpaciente }, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

//Funcion para desincorporar al paciente de la sala de consulta
function noatendido(idpaciente) {
    bootbox.confirm("¿Está seguro de devolver al paciente a la sala de espera?", function(result){
        if (result) {
            $.post("../ajax/registro.php?op=noatendido", { idpaciente : idpaciente }, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

init();