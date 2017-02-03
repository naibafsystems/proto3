$(document).ready(function () {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    var ruta_url = $('#ruta').val();
    var tipo_comision = $('#tipo_comision').val();
    var aspecto = $('#aspecto_sel').val();
    var criterio = $('#criterio_sel').val();

    switch (tipo_comision) {
        case "2":
            $('#TabAprendizaje').removeClass("active");
            $('#TabNacional').addClass("active");
            $('#TblInternacional').removeClass("active");
            if (aspecto == "p") {
                $('#Positivos').addClass("active");
                $('#Mejorar').removeClass("active");
                $('#Aplicaciones').removeClass("active");
            } else if (aspecto == "n") {
                $('#Positivos').removeClass("active");
                $('#Mejorar').addClass("active");
                $('#Aplicaciones').removeClass("active");
            } else {
                $('#Positivos').removeClass("active");
                $('#Mejorar').removeClass("active");
                $('#Aplicaciones').addClass("active");
            }
            $('#CriterioSel').hide();
            break;
        case "3":
            $('#TabAprendizaje').removeClass("active");
            $('#TabNacional').removeClass("active");
            $('#TblInternacional').addClass("active");
            if (aspecto == "p") {
                $('#Positivos').addClass("active");
                $('#Mejorar').removeClass("active");
                $('#Aplicaciones').removeClass("active");
            } else if (aspecto == "n") {
                $('#Positivos').removeClass("active");
                $('#Mejorar').addClass("active");
                $('#Aplicaciones').removeClass("active");
            } else {
                $('#Positivos').removeClass("active");
                $('#Mejorar').removeClass("active");
                $('#Aplicaciones').addClass("active");
            }
            $('#CriterioSel').hide();
            break;
        default:
            $('#TabAprendizaje').addClass("active");
            $('#TabNacional').removeClass("active");
            $('#TblInternacional').removeClass("active");
            if (aspecto == "p") {
                $('#Positivos').addClass("active");
                $('#Mejorar').removeClass("active");
                $('#Aplicaciones').removeClass("active");
            } else if (aspecto == "n") {
                $('#Positivos').removeClass("active");
                $('#Mejorar').addClass("active");
                $('#Aplicaciones').removeClass("active");
            } else {
                $('#Positivos').removeClass("active");
                $('#Mejorar').removeClass("active");
                $('#Aplicaciones').addClass("active");
            }

            $('#CriterioSel').show();
            $('#CriterioSel > option[value="' + criterio + '"]').attr('selected', 'selected');
            break;
    }

    $('#TabAprendizaje').click(function () {
        var url = ruta_url + "/1/p";
        $(location).attr('href', url);
    });

    $('#TabNacional').click(function () {
        var url = ruta_url + "/2/p";
        $(location).attr('href', url);
    });

    $('#TblInternacional').click(function () {
        var url = ruta_url + "/3/p";
        $(location).attr('href', url);
    });

    $('#Positivos').click(function () {
        switch (tipo_comision) {
            case "2":
                var url = ruta_url + "/2/p";
                break;
            case "3":
                var url = ruta_url + "/3/p";
                break;
            default:
                var url = ruta_url + "/1/p";
                break;
        }
        $(location).attr('href', url);
    });

    $('#Mejorar').click(function () {
        switch (tipo_comision) {
            case "2":
                var url = ruta_url + "/2/n";
                break;
            case "3":
                var url = ruta_url + "/3/n";
                break;
            default:
                var url = ruta_url + "/1/n";
                break;
        }
        $(location).attr('href', url);
    });

    $('#Aplicaciones').click(function () {
        switch (tipo_comision) {
            case "2":
                var url = ruta_url + "/2/a";
                break;
            case "3":
                var url = ruta_url + "/3/a";
                break;
            default:
                var url = ruta_url + "/1/a";
                break;
        }
        $(location).attr('href', url);
    });

    $('#CriterioSel').change(function () {
        var criterio_sel = $(this).val();
        if (aspecto == "p") {
            switch (criterio_sel) {
                case "1":
                    var url = ruta_url + "/1/p/1";
                    break;
                case "2":
                    var url = ruta_url + "/1/p/2";
                    break;
                case "3":
                    var url = ruta_url + "/1/p/3";
                    break;
                case "4":
                    var url = ruta_url + "/1/p/4";
                    break;
                case "5":
                    var url = ruta_url + "/1/p/5";
                    break;
                default:
                    var url = ruta_url + "/1/p";
                    break;
            }
        } else {
            switch (criterio_sel) {
                case "1":
                    var url = ruta_url + "/1/n/1";
                    break;
                case "2":
                    var url = ruta_url + "/1/n/2";
                    break;
                case "3":
                    var url = ruta_url + "/1/n/3";
                    break;
                case "4":
                    var url = ruta_url + "/1/n/4";
                    break;
                case "5":
                    var url = ruta_url + "/1/n/5";
                    break;
                default:
                    var url = ruta_url + "/1/p";
                    break;
            }
        }

        $(location).attr('href', url);
    });
    /*var id_ruta = $('#llave').val();
     var destino = $('#salida').val();
     
     carga_ajax(ruta_url,id_ruta,destino);*/

    $('#TblComisiones').DataTable({
        "order": [[1, "asc"]],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por p&aacute;gina",
            "zeroRecords": "No se encontraron Registros",
            "info": "Mostrando p&aacute;gina _PAGE_ de _PAGES_",
            "infoEmpty": "No se encontraron registros",
            "infoFiltered": "(Filtrado de _MAX_ total de Registros)",
            "search": "Buscar"
        }
    });
}
);

function carga_ajax(ruta, id, div) {
    // alert(ruta );
    $.post(ruta, {id: id}, function (resp) {
        $("#" + div + "").html(resp);
    });
}
