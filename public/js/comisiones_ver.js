$(document).ready(function() {
    
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
    
    var autor = $("#autor").val();
    var lector = $("#lector").val();    
    var tipo = $("#tipo").val();
    var tema = $("#tema").val();
    
    $('#TblAprendizaje').hide();
    $('#TblNacional').hide();
    $('#TblInternacional').hide();
    $('#DivConclusiones').hide();
    $('#DivCompromisos').hide();
    $('#aplicaciones').hide();
        
    switch (tipo) {
        case "N":
            $('#DivConclusiones').show();
            switch (tema) {
                case "1":
                case "2":
                case "3":
                case "5":
                case "6":
                case "7":
                    $('#TblNacional').show();
                    $('#aplicaciones').show();
                    break;
                case "4":
                    $('#TblAprendizaje').show();
                    $('#aplicaciones').hide();
                    break;
            }
            break;
        case "S":
            $('#DivCompromisos').show();
            $('#TblInternacional').show();
            break;
    }   

    $('.estrella').hover(function(){
        if (autor != lector){
            var parent = $(this).parent().attr('id');

            $('#'+parent+' .estrella').css('background-image', 'url(http://somos.dane.gov.co/comisiones/public/images/estrella-gris.png)');

			for(i=1;i<=$(this).attr('data');i++){
				$('#'+parent+'_'+i).css('background-image', 'url(http://somos.dane.gov.co/comisiones/public/images/estrella-verde.png)');
			}
		}
    });
    
    $('.estrella').click(function(){
        
        if (autor != lector){

            var parent = $(this).parent().attr('id');
            var service = $(this).parent().attr('data');
            var rating = $(this).attr('data');
            var url_page = $(this).attr('data-url');

            var dataString = 'id='+service+'&rating='+rating;

            $.ajax({
                type: "POST",
                url: url_page+"index.php/comisiones/votar",
                data: dataString,
                success: function() {        
                    var new_sum_rating = parseInt($('#'+parent+' #sumrating').attr('data')) + parseInt(rating);
                    var new_num_rating = parseInt($('#'+parent+' #numrating').attr('data')) + 1;
                    var new_rating = Math.round(new_sum_rating / new_num_rating);

                    for(i=1;i<=new_rating;i++){
                        $('#'+parent+'_'+i+' .estrella').removeClass("estrella");
                        $('#'+parent+'_'+i+' .estrella').addClass("selected");
                    }

                    $('#'+parent+' .ok').empty();
                    $('#'+parent+' #actual').empty();
                    $('#'+parent+' #actual').append(+new_num_rating+ ' Votos, Promedio '+new_rating+'').fadeIn("slow");
                    $('#'+parent+' .ok').append('Gracias por enviar tu voto!').fadeIn("slow");
                    //$('#'+parent+' #actual').fadeOut(5000);
                    $('#'+parent+' .ok').fadeOut(5000);
                }

            });
        }

    });  
});