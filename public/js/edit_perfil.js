$(document).ready(function () {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

});

function carga_ajax(ruta, id, div) {
    //alert(id);
    $.post(ruta, {id: id}, function (resp) {
        $("#" + div + "").html(resp);
    });
}

$(function () {
    // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
    $("#agregar").on('click', function () {
        $("#TblIdioma tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#TblIdioma tbody");
    });

    // Evento que selecciona la fila y la elimina 
    $(document).on("click", ".eliminar", function () {
        var parent = $(this).parents().get(0);
        $(parent).remove();
    });
});

$(function () {
    // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
    $("#agregarsw").on('click', function () {
        $("#Tblsw tbody tr:eq(0)").clone().removeClass('fila-base-sw').appendTo("#Tblsw tbody");
    });

    // Evento que selecciona la fila y la elimina 
    $(document).on("click", ".eliminarsw", function () {
        var parent = $(this).parents().get(0);
        $(parent).remove();
    });
});