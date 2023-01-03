//imprimos la lista, (primera vez)
recargar_instructores();

//Mostrar la lista de Instructors
function recargar_instructores() {
    $.ajax({
                data: {
            nulo: "0"
        },
        url: 'lista_instructores.php',
        type: 'POST',
        success: function(response) {
            $("#lista-instructores").html(response);
                }
    })
}

//ACTULIZAMOS
function actulizarInstructor(id, texto, columna){
    $.ajax({
        url:"actulizar_Instructor.php",
        method: "POST",
        data: {id: id, texto: texto, columna: columna},
        success: function(data){
            // obtener_datos(a);
            alert(data);
            recargar_instructores();
        }
    })
}

function selecion(str, id) {
    actulizarInstructor(id, str, "status")
}

// ELMINAR Instructor, DEFINITIVAMENTE
$(document).on("click", "#eliminar_instructor", function() {
    if (confirm("¿Esta seguro que desea eliminar a este instructor definitivamente? ")) {
        var id = $(this).data("id");
        var texto = "Eliminar"
        actulizarInstructor(id, texto, "eliminar")
    };
})