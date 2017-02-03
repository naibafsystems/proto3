$(document).ready(function() {
        
        var ruta_url = $('#ruta').val();
        var tipo_comision = $('#tipo_comision').val();
        var aspecto = $('#aspecto_sel').val();
        var criterio = $('#criterio_sel').val();        
        
        switch (tipo_comision){
            case "2":
                $('#TabAprendizaje').removeClass("active");
                $('#TabNacional').addClass("active");
                $('#TblInternacional').removeClass("active");
                break;
            case "3":
                $('#TabAprendizaje').removeClass("active");
                $('#TabNacional').removeClass("active");
                $('#TblInternacional').addClass("active");
                break;
            default:
                $('#TabAprendizaje').addClass("active");
                $('#TabNacional').removeClass("active");
                $('#TblInternacional').removeClass("active");
                break;
        }
        
        $('#TabAprendizaje').click(function(){
            var url = ruta_url + "/1";
            $(location).attr('href',url);
        });
        
        $('#TabNacional').click(function(){
            var url = ruta_url + "/2";
            $(location).attr('href',url);
        });
        
        $('#TblInternacional').click(function(){
            var url = ruta_url + "/3";
            $(location).attr('href',url);
        });

        $('#TblComisiones').DataTable({
            "order": [[ 1, "asc" ]],
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

function carga_ajax(ruta,id,div){
    // alert(ruta );
    $.post(ruta,{id:id},function(resp){
        $("#"+div+"").html(resp);
    });
}
