$(document).ready(function() {
        $('#TblComisionesPend').DataTable({
            "order": [[ 2, "acs" ]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por p&aacute;gina",
                "zeroRecords": "No se encontraron Registros",
                "info": "Mostrando p&aacute;gina _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(Filtrado de _MAX_ Total de registros)",
                "search": "Buscar"
            }
        });
        
        $('#TblComisionesComple').DataTable({
            "order": [[ 2, "desc" ]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por p&aacute;gina",
                "zeroRecords": "No se encontraron Registros",
                "info": "Mostrando p&aacute;gina _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(Filtrado de _MAX_ total de registros)",
                "search": "Buscar"
            }
        });
        
        $(document).on("click", "#AddMapa", function () {
            var idmapa = $(this).data('idmapa');
                        
            $("#lugar").empty();    
            
            //Enviamos el valor del data a la ventana modal.  
            $("#lugar").val(idmapa); 
        }); 
    } 
);

function carga_ajax(ruta,id,div){
    // alert(ruta );
    $.post(ruta,{id:id,},function(resp){
        $("#"+div+"").html(resp);
    });
}
