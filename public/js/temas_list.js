$(document).ready(function() {
        $('#tbltema').DataTable({
            "order": [[ 0, "asc" ]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ Registros por Página",
                "zeroRecords": "No se encontraron Registros",
                "info": "Mostrando Página _PAGE_ de _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(Filtrado de _MAX_ Total de Registros)",
                "search": "Buscar"
            }
        });
        
        $(document).on("click", "#EditTema", function () {
            var idtema = $(this).data('idtema');
            var tema = $(this).data('tema');
            var detalle = $(this).data('detalle');
            var tipo = $(this).data('tipo');
                        
            $("#idtema").empty();
            $("#temae").empty();    
            $("#detalle_temae").empty();
            //$("#tipo_temae").empty();
            
            //Enviamos el valor del data a la ventana modal.
            $("#idtema").val(idtema);  
            $("#temae").val(tema); 
            $("#detalle_temae").val(detalle);
            $('#tipo_temae > option[value='+tipo+']').attr('selected', 'selected');
            //$("#tipo_temae").val(tipo_tema);
            
        }); 
        
        $(document).on("click", "#DeleteTema", function () {
            var idtema = $(this).data('idtema');
            var tema = $(this).data('tema');
            var detalle = $(this).data('detalle');
                        
            $("#idtemab").empty();
            $("#temab").empty();    
            $("#detalleb").empty();
            
            //Enviamos el valor del data a la ventana modal.
            $("#idtemab").val(idtema);  
            $("#temab").html(tema); 
            $("#detalleb").html(detalle);
        }); 
        
    } 
);

function carga_ajax(ruta,id,div){
    // alert(ruta );
    $.post(ruta,{id:id},function(resp){
        $("#"+div+"").html(resp);
    });
}
