$(document).ready(function() {
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
    
    $('#defaultForm').bootstrapValidator({
        message: 'El Valor ingresado no es Valido',
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },fields: {
            tipo: {
                message: 'El tipo de comisi�n no es valido',
                validators: {
                    notEmpty: {
                        message: 'El tipo de comisi�n es requerido'
                    }
                }
            },
            tema: {
                message: 'El tema de comisi�n no es valido',
                validators: {
                    notEmpty: {
                        message: 'El tema de la comisi�n es requerido'
                    }
                }
            },
            resumen: {
                message: 'El resumen de la comisi�n no es valido',
                validators: {
                    notEmpty: {
                        message: 'El resumen de la comisi�n es requerido'
                    },
                    stringLength: {
                        min: 200,
                        max: 600,
                        message: 'El resumen debe contener entre 200 y 600 caractares'
                    }
                }
            },
            tipo_archivo: {
                message: 'Tipo de documento no es valido',
                validators: {
                    notEmpty: {
                        message: 'Tipo de documento es requerido'
                    }
                }
            }
        }
    });
    
    $(document).on("click", "#EditContacto", function () {
        var idcontacto = $(this).data('idcontacto');
        var nombre = $(this).data('nombre');
        var apellido = $(this).data('apellido');
        var cargo = $(this).data('cargo');
        var mail = $(this).data('mail');
        var telefono = $(this).data('telefono');

        $("#idcontacto_edit").empty();
        $("#nombre_edit").empty();    
        $("#apellido_edit").empty();
        $("#cargo_edit").empty();
        $("#mail_edit").empty();
        $("#telefono_edit").empty();

        //Enviamos el valor del data a la ventana modal.
        $("#idcontacto_edit").val(idcontacto);  
        $("#nombre_edit").val(nombre); 
        $("#apellido_edit").val(apellido);
        $("#cargo_edit").val(cargo);
        $("#mail_edit").val(mail);
        $("#telefono_edit").val(telefono);
    }); 

    $(document).on("click", "#DeleteContacto", function () {
        var idcontacto = $(this).data('idcontacto');
        var nombre = $(this).data('nombre');
        var apellido = $(this).data('apellido');
        var cargo = $(this).data('cargo');
        var mail = $(this).data('mail');
        var telefono = $(this).data('telefono');

        $("#idcontacto_delete").empty();
        $("#nombre_delete").empty();    
        $("#apellido_delete").empty();
        $("#cargo_delete").empty();
        $("#mail_delete").empty();
        $("#telefono_delete").empty();

        //Enviamos el valor del data a la ventana modal.
        $("#idcontacto_delete").val(idcontacto);  
        $("#nombre_delete").html(nombre); 
        $("#apellido_delete").html(apellido);
        $("#cargo_delete").html(cargo);
        $("#mail_delete").html(mail);
        $("#telefono_delete").html(telefono);
    }); 
    
    $(document).on("click", "#DeleteArchivo", function () {
        var idarchivo = $(this).data('idarchivo');
        var ruta = $(this).data('rutasvr');
        var iddatos = $('#id_datos').val();
        var tipocomi = $(this).data('tipocomi');
        var RutaFinal = ruta + "/Comisiones/delete_file_comi/" + idarchivo + "/" + iddatos + "/" + tipocomi;
        
        $("#defaultForm").submit();
         window.location = RutaFinal;
    }); 
    
    $('#editfileleg').on('show.bs.modal', function (e) {
        $('#Formeditfile').bootstrapValidator('addField', 'newfile', {
            validators: {
                notEmpty: {
                    message: 'El documento es requerido es requerido'
                },
                file: {
                    extension: 'pdf',
                    type: 'application/pdf',
                    message: 'Seleccione un archivo valido debe ser pdf.'
                }
            }
        });
    });
    
    $('#editfileleg').on('hidden.bs.modal', function (e) {
        $('#Formeditfile').bootstrapValidator('removeField', 'newfile');
    });
    
    $(document).on("click", "#EditFileLeg", function () {
        var idfile = $(this).data('idfile');
        var tipo = $(this).data('tipo');
        var archivo = $(this).data('nomfile');
        
        var Titulo = "";
        
        switch(tipo){
            case "A":
                Titulo = "Pasabordos";
                break;
            case "C":
                Titulo = "Certificado Permanencia";
                break;
            case "T":
                Titulo = "Tiquetes terrestres";
                break;
            default :
                Titulo = "Otro";
                break;
        }

        $("#TituloForm").empty();
        $("#IdFileNew").empty();  
        $("#fileold").empty();
        $("#TipFile").empty();

        //Enviamos el valor del data a la ventana modal.
        $("#TituloForm").html(Titulo);  
        $("#fileold").html(archivo);  
        $("#IdFileNew").val(idfile); 
        $("#TipFile").val(tipo); 
    }); 

    $('#defaultForm').bootstrapValidator('removeField', 'conclusiones');
    var tipo = $("#tipo").val();
    var tema = $("#tema").val();
    
    $('#TblAprendizaje').hide();
    $('#TblNacional').hide();
    $('#TblInternacional').hide();
    $('#aplicaciones').hide();
        
    switch (tipo) {
        case "N":
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
            $('#TblInternacional').show();
            $('#aplicaciones').show();
            break;
    }    
    
    $("#tema").change(function(){
        var tipo = $("#tipo").val();
        var tema = $(this).val();
        if (tipo == "S"){
            $('#TblAprendizaje').hide();
            $('#TblNacional').hide();
            $('#TblInternacional').show();
            $('#aplicaciones').show();
            $('#defaultForm').bootstrapValidator('addField', 'temas_tra', {
                validators: {
                    notEmpty: {
                        message: 'Los temas tratados de la comisi�n son requeridos'
                    },
                    stringLength: {
                        max: 1000,
                        message: 'Los temas tratados debe contener maximo 1000 caractares'
                    }
                }
            });
            $('#defaultForm').bootstrapValidator('addField', 'lecciones', {
                validators: {
                    notEmpty: {
                        message: 'Las fortalezas y aspectos positivos son requeridos'
                    },
                    stringLength: {
                        max: 1000,
                        message: 'Las fortalezas y aspectos positivos deben contener maximo 1000 caractares'
                    }
                }
            });
            $('#defaultForm').bootstrapValidator('addField', 'oportunidades', {
                validators: {
                    notEmpty: {
                        message: 'Las oportunidades de mejora son requeridos'
                    },
                    stringLength: {
                        max: 1000,
                        message: 'Las oportunidades de mejora deben contener maximo 1000 caractares'
                    }
                }
            });
        }else{
            $('#defaultForm').bootstrapValidator('removeField', 'temas_tra');
            $('#defaultForm').bootstrapValidator('removeField', 'lecciones');
            $('#defaultForm').bootstrapValidator('removeField', 'oportunidades');
            switch (tema) {
                case "4":
                    $('#defaultForm').bootstrapValidator('removeField', 'nal_actdesarro');
                    $('#defaultForm').bootstrapValidator('removeField', 'nal_positivos');
                    $('#defaultForm').bootstrapValidator('removeField', 'nal_dificultades');
                    
                    $('#TblAprendizaje').show();
                    $('#TblNacional').hide();
                    $('#TblInternacional').hide();
                    $('#aplicaciones').hide();
                    
                    $('#defaultForm').bootstrapValidator('addField', 'asp_convocatoria', {
                        validators: {
                            notEmpty: {
                                message: 'Fortalezas y aspectos positivos son requeridos'
                            },
                            stringLength: {
                                max: 600,
                                message: 'Fortalezas y aspectos positivos deben contener maximo 600 caractares'
                            }
                        }
                    });
                    
                    $('#defaultForm').bootstrapValidator('addField', 'dif_convocatoria', {
                        validators: {
                            notEmpty: {
                                message: 'Oportunidades de mejora son requeridos'
                            },
                            stringLength: {
                                max: 600,
                                message: 'Oportunidades de mejora deben contener maximo 600 caractares'
                            }
                        }
                    });
                    
                    $('#defaultForm').bootstrapValidator('addField', 'asp_logistica', {
                        validators: {
                            notEmpty: {
                                message: 'Fortalezas y aspectos positivos son requeridos'
                            },
                            stringLength: {
                                max: 600,
                                message: 'Fortalezas y aspectos positivos deben contener maximo 600 caractares'
                            }
                        }
                    });
                    
                    $('#defaultForm').bootstrapValidator('addField', 'dif_logistica', {
                        validators: {
                            notEmpty: {
                                message: 'Oportunidades de mejora son requeridos'
                            },
                            stringLength: {
                                max: 600,
                                message: 'Oportunidades de mejora deben contener maximo 600 caractares'
                            }
                        }
                    });
                    
                    $('#defaultForm').bootstrapValidator('addField', 'asp_entrevista', {
                        validators: {
                            notEmpty: {
                                message: 'Fortalezas y aspectos positivos son requeridos'
                            },
                            stringLength: {
                                max: 600,
                                message: 'Fortalezas y aspectos positivos deben contener maximo 600 caractares'
                            }
                        }
                    });
                    
                    $('#defaultForm').bootstrapValidator('addField', 'dif_entrevista', {
                        validators: {
                            notEmpty: {
                                message: 'Oportunidades de mejora son requeridos'
                            },
                            stringLength: {
                                max: 600,
                                message: 'Oportunidades de mejora deben contener maximo 600 caractares'
                            }
                        }
                    });
                    
                    $('#defaultForm').bootstrapValidator('addField', 'asp_desarrollo', {
                        validators: {
                            notEmpty: {
                                message: 'Fortalezas y aspectos positivos son requeridos'
                            },
                            stringLength: {
                                max: 600,
                                message: 'Fortalezas y aspectos positivos deben contener maximo 600 caractares'
                            }
                        }
                    });
                    
                    $('#defaultForm').bootstrapValidator('addField', 'dif_desarrollo', {
                        validators: {
                            notEmpty: {
                                message: 'Oportunidades de mejora son requeridos'
                            },
                            stringLength: {
                                max: 600,
                                message: 'Oportunidades de mejora deben contener maximo 600 caractares'
                            }
                        }
                    });
                    
                    $('#defaultForm').bootstrapValidator('addField', 'asp_plataforma', {
                        validators: {
                            notEmpty: {
                                message: 'Fortalezas y aspectos positivos son requeridos'
                            },
                            stringLength: {
                                max: 600,
                                message: 'Fortalezas y aspectos positivos deben contener maximo 600 caractares'
                            }
                        }
                    });
                    
                    $('#defaultForm').bootstrapValidator('addField', 'dif_plataforma', {
                        validators: {
                            notEmpty: {
                                message: 'Oportunidades de mejora son requeridos'
                            },
                            stringLength: {
                                max: 600,
                                message: 'Oportunidades de mejora deben contener maximo 600 caractares'
                            }
                        }
                    });
                    break;
                default:
                    $('#TblAprendizaje').hide();
                    $('#TblNacional').show();
                    $('#TblInternacional').hide();
                    $('#aplicaciones').show();
                    $('#defaultForm').bootstrapValidator('addField', 'nal_actdesarro', {
                        validators: {
                            notEmpty: {
                                message: 'Las actividades desarrolladas son requeridos'
                            },
                            stringLength: {
                                max: 1000,
                                message: 'Las actividades desarrolladas deben contener maximo 1000 caractares'
                            }
                        }
                    });
                    $('#defaultForm').bootstrapValidator('addField', 'nal_positivos', {
                        validators: {
                            notEmpty: {
                                message: 'Las fortalezas y aspectos positivos son requeridos'
                            },
                            stringLength: {
                                max: 1000,
                                message: 'Las fortalezas y aspectos positivos deben contener maximo 1000 caractares'
                            }
                        }
                    });
                    $('#defaultForm').bootstrapValidator('addField', 'nal_dificultades', {
                        validators: {
                            notEmpty: {
                                message: 'Las oportunidades de mejora son requeridos'
                            },
                            stringLength: {
                                max: 1000,
                                message: 'Las oportunidades de mejora deben contener maximo 1000 caractares'
                            }
                        }
                    });
                    $('#defaultForm').bootstrapValidator('removeField', 'asp_convocatoria');
                    $('#defaultForm').bootstrapValidator('removeField', 'dif_convocatoria');
                    $('#defaultForm').bootstrapValidator('removeField', 'asp_logistica');
                    $('#defaultForm').bootstrapValidator('removeField', 'dif_logistica');
                    $('#defaultForm').bootstrapValidator('removeField', 'asp_entrevista');
                    $('#defaultForm').bootstrapValidator('removeField', 'dif_entrevista');
                    $('#defaultForm').bootstrapValidator('removeField', 'asp_desarrollo');
                    $('#defaultForm').bootstrapValidator('removeField', 'dif_desarrollo');
                    $('#defaultForm').bootstrapValidator('removeField', 'asp_plataforma');
                    $('#defaultForm').bootstrapValidator('removeField', 'dif_plataforma');
                    break;
            }   
        } 
    });
    
});

// Adicionar Filas a la tabla de Opciones
function addTableRow(table) {
    var $tr = $(table).find('tr:last').clone();
    $tr.find('input').attr('value',"");
    
    var id_fila="fila"+eval($(table).find('tr').length+1);
    
    var fila=$(table).find('tr:last');
    var n = $(table).find('tr:last td').length;
    var tds = '<tr id="'+id_fila+'"><td>'+$(table).find('tr:last td').html()+'</td>';
            for(var i = 0; i < n-2; i++){
                tds += '<td>'+$(table).find('tr:last td:gt('+i+')').html()+'</td>';
            }
    // Adicionar la ultina columna
    var fn_click="removeTableRow('#"+id_fila+"')";
    
    	tds += "<td><button type='button' class='btn btn-default btn-sm ' onclick="+fn_click+" title='Eliminar el documento adjunto'>Eliminar</button></td>";	
        tds += '</tr>';
    
    $(table).append(tds);
    return true;
}

function removeTableRow(id_fila) {
    $(id_fila).remove();
}

$(function () {
    // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
    $("#agregarsw").on('click', function () {
        $("#TblNacional tbody tr:eq(0)").clone().removeClass('fila-base-sw').appendTo("#TblNacional tbody");
    });

    // Evento que selecciona la fila y la elimina 
    $(document).on("click", ".eliminarsw", function () {
        var parent = $(this).parents().get(0);
        console.log(parent);
        $(parent).remove();
    });
});