$(document).ready(function() {
    $('#inguser2').bootstrapValidator({
        message: 'El Valor ingresado no es Valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },fields: {
            inputLogin: {
                message: 'El Usuario no es Valido',
                validators: {
                    notEmpty: {
                        message: 'El Usuario es requerido y no puede estar vacio'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'El usuario debe contener entre 6 y 30 caractares'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'El usuario solo puede se alfabetico sin caracteres especiales'
                    },
                    different: {
                        field: 'inputPassword',
                        message: 'El usuario y el password no puedes ser iguales'
                    }
                }
            },
            inputPassword: {
                validators: {
                    notEmpty: {
                        message: 'El password es requerido y no puedeestar vacio'
                    },
                    different: {
                        field: 'inputLogin',
                        message: 'El password no puede ser igual al Usuario'
                    }
                }
            }
        }
    });
});
    
function carga_ajax(ruta,id,div){
    $.post(ruta,{id:$('#inputLogin').val()},function(resp){
        $("#"+div+"").html(resp);
    });
}

$(function(){
    var $winWid = $(window).width();
    var $minus = $('.logo-wrapper').outerHeight() + $('#colorbar').outerHeight();

    if ( $winWid >= 768){
        $(window).on('resize', function(){
            var $windowH = $(window).outerHeight();
            $('.w-h-1').css('height', $windowH);
            $('.w-h-2').css('height', $windowH - $minus);

        }).resize();
    }

    
})