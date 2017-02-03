$(document).ready(function () {
    
	$('.formRevision').validationEngine({
        promptPosition: "bottomLeft",
        scroll: false,
        autoHidePrompt: true,
        autoHideDelay: 3000
    });
    $('.formRevision').submit(function () {
        var $resultado = $('.formRevision').validationEngine("validate");   
    });
    

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
	
	
	$( "#carga_info" ).click(function() {
		
		if($("#doc_iden").val() == ''){
			alert('Debe digitar un documento valido');
		}else{
			var identificacion = $("#doc_iden").val();
			$.ajax({
				type: "POST",
				url: "cargaDatos",
				dataType: 'json',
				data: {identificacion: identificacion},
				success: function(res) {
					if (res)
					{						
						if(res.datos == 'OK'){
							// Show Entered Value
							$("div#divDatos").show();
							$("#nombres").val(res.nombres);
							$("#apellidos").val(res.apellidos);  
							$("#email").val(res.mail);
							$("#grupo").val(res.grupo);
						}else{
							$("div#divDatos").hide();
						}					
					}
				}
			});
		}
	});
	
	$( "#territorial" ).change(function() {
		
		var territorial = $("#territorial").val();
		
		if(territorial != ''){
			$.ajax({
				type: "POST",
				url: "cargarCiudad",
				dataType: 'html',
				data: {territorial: territorial},
				success: function(res) {
											
					$("#ciudad").html(res);									
					
				}
			});
		}
	});
	
	$( "#tipo_vinc" ).change(function() {
		
		var tipo_vinc = $("#tipo_vinc").val();
		
		if(tipo_vinc == 5){
			$("p#campo_tipo_vinc").show();
		}else{
			$("p#campo_tipo_vinc").hide();
		}
		
		if(tipo_vinc == 1){
			$("div#div_ff").show();
		}else{
			$("div#div_ff").hide();
		}
		
	});
	
	
	
	$.datepicker.regional['es'] = {
		 closeText: 'Cerrar',
		 prevText: '<Ant',
		 nextText: 'Sig>',
		 currentText: 'Hoy',
		 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		 weekHeader: 'Sm',
		 dateFormat: 'dd/mm/yy',
		 firstDay: 1,
		 isRTL: false,
		 showMonthAfterYear: false,
		 yearSuffix: ''
	};
	
	$.datepicker.setDefaults($.datepicker.regional['es']);
	
	$( "#fecha_vinculacion" ).datepicker({
		dateFormat: 'yy-mm-dd',
	    changeMonth: true,
        changeYear: true
	});  
	 
	$( "#fecha_finalizacion" ).datepicker({
		 dateFormat: 'yy-mm-dd',
		 changeMonth: true,
		 changeYear: true
	});
	
	$('.formInscripcion').validationEngine({
        promptPosition: "bottomLeft",
        scroll: false,
        autoHidePrompt: true,
        autoHideDelay: 3000
    });
    $('.formInscripcion').submit(function () {
        var $resultado = $('.formInscripcion').validationEngine("validate");   
    });

});

function validarEstado(id){
	
	var estado = $('#estado'+id).val();  
	//alert(id);
	if(estado == '3'){
		//alert(estado);
		//$("#tipo_cuenta" + id).removeClass();
		$('input:radio[id=tipo_cuenta'+id+']').removeClass();
		$("#c_informe" + id).removeClass();
		$("#div_doc" + id).show();
	}else{
		$('input:radio[id=tipo_cuenta'+id+']').addClass("validate[required]");
		$("#c_informe" + id).addClass( "validate[required]" );		
		$("#div_doc" + id).hide();
	}
}

function ocultarDocRe(id){
	$("#div_docRein" + id).css("display","none");	
}


function mostrarDocRe(id){
	$("#div_docRein" + id).css("display","block");	
}