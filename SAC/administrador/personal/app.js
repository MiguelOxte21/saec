//imprimos la lista, (primera vez)
recargar_alumnos();

//Mostrar la lista de alumnos
function recargar_alumnos() {
    $.ajax({
                data: {
            nulo: "0"
        },
        url: 'lista_alumnos.php',
        type: 'POST',
        success: function(response) {
            $("#lista-alumno").html(response);
                }
    })
}

//ACTULIZAMOS
function actulizarAlumno(id, texto, columna){
    $.ajax({
        url:"actulizar_alumno.php",
        method: "POST",
        data: {id: id, texto: texto, columna: columna},
        success: function(data){
            // obtener_datos(a);
            // alert(data);
            recargar_alumnos();
        }
    })
}

//OBTENER COMENTARIO
$(document).on("blur", "#comentario_alumno", function(){
    var id = $(this).data("id_alumno");
    var comentario = $(this).text();
    
    actulizarAlumno(id, comentario, "comentarios")
});

function selecion(str, id) {
    actulizarAlumno(id, str, "status")
}

// ELMINAR ALUMNO, DEFINITIVAMENTE
$(document).on("click", "#eliminar_alumno", function() {
    if (confirm("Esta seguro que desea eliminar este alumno definitivamente? ")) {
        var id = $(this).data("id");
        var texto = "Eliminar"
        actulizarAlumno(id, texto, "eliminar")
    };
})