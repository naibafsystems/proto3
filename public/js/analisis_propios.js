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

function carga_ajax(ruta,id,id2,id3,div){
    
    $.post(ruta,{id:id,id2:id2,id3:id3},function(resp){
        $("#"+div+"").html(resp);
    });
    
    location.reload();
}

function clickbutton(id){
    
    var ruta_url = $('#ruta').val();
    //var ruta = $('#ruta_exito').val();
    var actividad = $('#actividad'+id).val();
    var fecha = $('#fecha'+id).val();
    
    if (actividad == ""){
        alert("La actividad no puede estar vacio");
        $('#actividad'+id).focus();
    }else if(fecha == "" ){
        alert("La fecha de la actividad no puede estar vacio");
        $('#fecha'+id).focus();
    }else{
        var id_analisis = parseInt(id);
        var url = ruta_url + "/" + id_analisis + "/" + actividad + "/" + fecha;
        //alert (url);
        carga_ajax(ruta_url,id_analisis,actividad,fecha,"prueba");
    }
}
