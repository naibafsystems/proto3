$(document).ready(function() {
        $('#TblComisiones').DataTable({
            "searching": false,
            "order": [[ 2, "desc" ]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por p&aacute;gina",
                "zeroRecords": "No se encontraron Registros",
                "info": "Mostrando p&aacute;gina _PAGE_ de _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(Filtrado de _MAX_ total de Registros)",
                "search": "Buscar"
            }
        });
        
        $(document).on("click", "#AddMapa", function () {
            var idmapa = $(this).data('idmapa');
                        
            $("#lugar").empty();    
            
            //Enviamos el valor del data a la ventana modal.  
            $("#lugar").val(idmapa); 
        }); 
        
        /*$('#resumen').on('show.bs.modal', function (e) {
            var id_datos = $(this).data('whatever');
            var button = $(event.relatedTarget);
            var id_datos = button.data('whatever');
            
            var modal = $(this)
            modal.find('.modal-title').text('New message to ' + id_datos)
            
            $.post('http://localhost/somos/comisiones/index.php/comisiones/resumen',{id:id_datos},function(resp){
                $("#Ver_resumen").html(resp);
            });
        });*/
    } 
);

function carga_ajax(ruta,id,div){
    // alert(ruta );
    $.post(ruta,{id:id},function(resp){
        $("#"+div+"").html(resp);
    });
}