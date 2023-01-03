function recargar_t() {
    $.ajax({
                data: {
            lista_taller: "0"
        },
        url: 'lista_alumnos_taller.php',
        type: 'POST',
        success: function(response) {
            $("#lista-alumno").html(response);
                }
    })
}

function recargar_c() {
    $.ajax({
                data: {
            lista_taller: "0"
        },
        url: 'lista_alumnos_concurso.php',
        type: 'POST',
        success: function(response) {
            $("#lista-alumno").html(response);
                }
    })
}

function recargar_g() {
    var id_concurso = $(this).data("id_concurso");
    $.ajax({
        data: {
            id_concurso: id_concurso
        },
        url: 'lista_alumnos_concurso_grupal.php',
        type: 'POST',
        success: function(response) {
            $("#lista-alumno").html(response);
        }
    })
}

function recargar_conf() {
    $.ajax({
        data: {
            id_conf: "0"
        },
        url: 'lista_alumnos_conferencia.php',
        type: 'POST',
        success: function(response) {
            $("#lista-alumno").html(response);
        }
    })
}

$(document).on("click", "#eliminar_t", function() {
    if (confirm("Esta seguro que desea eliminar este alumno? ")) {
        var id = $(this).data("id");
        $.ajax({
            url: "eliminar_alumno.php",
            method: "POST",
            data: {
                id: id, lista: "taller"
            },
            success: function(data) {
                recargar_t();
            }
        })
    };
})

$(document).on("click", "#eliminar_c", function() {
    if (confirm("Esta seguro que desea eliminar este alumno del concurso? ")) {
        var id = $(this).data("id");

        $.ajax({
            url: "eliminar_alumno.php",
            method: "POST",
            data: {
                id: id, lista: "concurso"
            },
            success: function(data) {
                recargar_c();
            }
        })
    };
})

$(document).on("click", "#eliminar_g", function() {
    if (confirm("Esta seguro que desea eliminar este alumno del concurso grupal? ")) {
        var id = $(this).data("id");

        $.ajax({
            url: "eliminar_alumno.php",
            method: "POST",
            data: {
                id: id, lista: "concurso_grupal"
            },
            success: function(data) {
                recargar_g();
            }
        })
    };
})

$(document).on("click", "#eliminar_conf", function() {
    if (confirm("Esta seguro que desea eliminar este alumno de la conferencia? ")) {
        var id = $(this).data("id");

        $.ajax({
            url: "eliminar_alumno.php",
            method: "POST",
            data: {
                id: id, lista: "conferencia"
            },
            success: function(data) {
                recargar_conf();
            }
        })
    };
})