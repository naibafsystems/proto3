$(document).ready(function () {
    $('#defaultForm').bootstrapValidator({
        message: 'El Valor ingresado no es Valido',
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        }, fields: {
            tipo: {
                message: 'El tipo de comisión no es valido',
                validators: {
                    notEmpty: {
                        message: 'El tipo de comisión es requerido'
                    }
                }
            },
            tema: {
                message: 'El tema de comisión no es valido',
                validators: {
                    notEmpty: {
                        message: 'El tema de la comisión es requerido'
                    }
                }
            },
            resumen: {
                message: 'El resumen de la comisión no es valido',
                validators: {
                    notEmpty: {
                        message: 'El resumen de la comisión es requerido'
                    },
                    stringLength: {
                        min: 200,
                        max: 1000,
                        message: 'El resumen debe contener entre 200 y 1000 caractares'
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
            },
            conclusiones: {
                message: 'Tipo de documento no es valido',
                validators: {
                    /*notEmpty: {
                     message: 'Las conclusiones de la comisión son requeridas'
                     },*/
                    stringLength: {
                        max: 800,
                        message: 'Las Recomendaciones o sugerencias deben contener maximo 800 caractares'
                    }
                }
            },
            certificadoper: {
                message: 'El Certificado de estadia no es valido',
                validators: {
                    notEmpty: {
                        message: 'El Certificado de estadia es requerido'
                    }
                }
            }
        }
    })
            .find('input[type="checkbox"][name="tipo_archivo[]"]')
            .on('change', function () {
                var topic = $(this).val(),
                        $container = $('[data-topic="' + topic + '"]');
                $container.toggle();

                var display = $container.css('display');
                switch (true) {
                    case ('1' == topic && 'block' == display):
                        $('#defaultForm').bootstrapValidator('addField', 'resumen_archivo', {
                            validators: {
                                notEmpty: {
                                    message: 'El resumen del documento es requerido'
                                },
                                stringLength: {
                                    max: 400,
                                    message: 'El resumen del documento debe contener maximo 400 caractares'
                                }
                            }
                        });
                        $('#defaultForm').bootstrapValidator('addField', 'archivo[]', {
                            validators: {
                                notEmpty: {
                                    message: 'El Documento es necesario'
                                },
                                file: {
                                    extension: 'pdf,doc,docx,xls,xlsx,ppt,pptx,rar,zip',
                                    type: 'application/pdf,application/msword,application/vnd.ms-excel,application/vnd.ms-powerpoint,application/x-rar-compressed,application/zip,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                    message: 'Seleccione un archivo valido.'
                                }
                            }
                        });
                        break;
                    case ('1' == topic && 'none' == display):
                        $('#defaultForm').bootstrapValidator('removeField', 'resumen_archivo');
                        $('#defaultForm').bootstrapValidator('removeField', 'archivo[]');
                        break;
                    case ('2' == topic && 'block' == display):
                        $('#defaultForm').bootstrapValidator('addField', 'resumen_imagen[]', {
                            validators: {
                                //notEmpty: {
                                //message: 'El resumen de la imagen es requerido'
                                //},
                                stringLength: {
                                    max: 400,
                                    message: 'El resumen de la imagen debe contener maximo 400 caractares'
                                }
                            }
                        });
                        $('#defaultForm').bootstrapValidator('addField', 'imagen[]', {
                            validators: {
                                notEmpty: {
                                    message: 'La imagen es requerida'
                                }
                            }
                        });
                        break;
                    case ('2' == topic && 'none' == display):
                        $('#defaultForm').bootstrapValidator('removeField', 'resumen_imagen[]');
                        break;
                }
            });

    var RutaAerea = $('#RutaA').length;
    var RutaTerrestre = $('#RutaT').length;
    var RutaOtra = $('#RutaO').length;
    var RutaOtraVal = $('#RutaO').val();

    if (RutaAerea > 0) {
        $('#defaultForm').bootstrapValidator('addField', 'pasabordo', {
            validators: {
                notEmpty: {
                    message: 'Pasabordo(s) requerido(s)'
                },
                file: {
                    extension: 'pdf',
                    type: 'application/pdf',
                    message: 'Seleccione un archivo valido debe ser pdf.'
                }
            }
        });
    }

    if (RutaTerrestre > 0) {
        $('#defaultForm').bootstrapValidator('addField', 'tiquete', {
            validators: {
                notEmpty: {
                    message: 'Tiquete(s) requerido(s)'
                },
                file: {
                    extension: 'pdf',
                    type: 'application/pdf',
                    message: 'Seleccione un archivo valido debe ser pdf.'
                }
            }
        });
    }

    if (RutaOtra > 0 && RutaOtraVal != "") {
        $('#defaultForm').bootstrapValidator('addField', 'otraruta', {
            validators: {
                notEmpty: {
                    message: 'Documento requerido'
                },
                file: {
                    extension: 'pdf',
                    type: 'application/pdf',
                    message: 'Seleccione un archivo valido debe ser pdf.'
                }
            }
        });
    }

    $('#TblAprendizaje').hide();
    $('#TblNacional').hide();
    $('#agregarsw').hide();
    $('#TblInternacional').hide();
    $('#aplicaciones').hide();
    
    var ValTema = $("#tema").val();
    
    if (ValTema != ""){
        var tipo = $("#tipo").val();
        var tema = $("#tema").val();
        var item = $('#items').val();

        if (tipo == "S") {
            $('#TblAprendizaje').hide();
            $('#aplicaciones').show();
            $('#TblNacional').hide();
            $('#agregarsw').hide();
            $('#TblInternacional').show();
            $('#defaultForm').bootstrapValidator('addField', 'temas_tra', {
                validators: {
                    notEmpty: {
                        message: 'Los temas tratados de la comisión son requeridos'
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
        } else {
            $('#defaultForm').bootstrapValidator('removeField', 'temas_tra');
            $('#defaultForm').bootstrapValidator('removeField', 'lecciones');
            $('#defaultForm').bootstrapValidator('removeField', 'oportunidades');

            switch (tema) {
                case "4":
                    $('#defaultForm').bootstrapValidator('removeField', 'nal_actdesarro');
                    $('#defaultForm').bootstrapValidator('removeField', 'nal_positivos');
                    $('#defaultForm').bootstrapValidator('removeField', 'nal_dificultades');

                    $('#TblAprendizaje').show();
                    $('#aplicaciones').hide();
                    $('#TblNacional').hide();
                    $('#agregarsw').hide();
                    $('#TblInternacional').hide();

                    for (var i = 1; i <= item; i++) {
                        $('#defaultForm').bootstrapValidator('addField', 'asp_positivos_' + i, {
                            validators: {
                                notEmpty: {
                                    message: 'Fortalezas y aspectos positivos son requeridos'
                                },
                                stringLength: {
                                    max: 2000,
                                    message: 'Fortalezas y aspectos positivos deben contener maximo 2000 caractares'
                                }
                            }
                        });

                        $('#defaultForm').bootstrapValidator('addField', 'oportunidades_mejora_' + i, {
                            validators: {
                                notEmpty: {
                                    message: 'Oportunidades de mejora son requeridos'
                                },
                                stringLength: {
                                    max: 2000,
                                    message: 'Oportunidades de mejora deben contener maximo 2000 caractares'
                                }
                            }
                        });

                        $('#defaultForm').bootstrapValidator('addField', 'aplicaciones_entidad_' + i, {
                            validators: {
                                notEmpty: {
                                    message: 'Aplicaciones para la entidad son requeridos'
                                },
                                stringLength: {
                                    max: 2000,
                                    message: 'Aplicaciones para la entidad deben contener maximo 2000 caractares'
                                }
                            }
                        });
                    }

                    break;
                default:
                    $('#TblAprendizaje').hide();
                    $('#aplicaciones').show();
                    $('#TblNacional').show();
                    $('#agregarsw').show();
                    $('#TblInternacional').hide();
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
                    for (var i = 1; i <= item; i++) {
                        $('#defaultForm').bootstrapValidator('removeField', 'asp_positivos_' + i);
                        $('#defaultForm').bootstrapValidator('removeField', 'oportunidades_mejora_' + i);
                        $('#defaultForm').bootstrapValidator('removeField', 'aplicaciones_entidad_' + i);
                    }
                    break;
            }
        }
    }

    $("#tema").change(function () {
        var tipo = $("#tipo").val();
        var tema = $(this).val();
        var item = $('#items').val();

        if (tipo == "S") {
            $('#TblAprendizaje').hide();
            $('#aplicaciones').show();
            $('#TblNacional').hide();
            $('#agregarsw').hide();
            $('#TblInternacional').show();
            $('#defaultForm').bootstrapValidator('addField', 'temas_tra', {
                validators: {
                    notEmpty: {
                        message: 'Los temas tratados de la comisión son requeridos'
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
        } else {
            $('#defaultForm').bootstrapValidator('removeField', 'temas_tra');
            $('#defaultForm').bootstrapValidator('removeField', 'lecciones');
            $('#defaultForm').bootstrapValidator('removeField', 'oportunidades');
            switch (tema) {
                case "4":
                    $('#defaultForm').bootstrapValidator('removeField', 'nal_actdesarro');
                    $('#defaultForm').bootstrapValidator('removeField', 'nal_positivos');
                    $('#defaultForm').bootstrapValidator('removeField', 'nal_dificultades');

                    $('#TblAprendizaje').show();
                    $('#aplicaciones').hide();
                    $('#TblNacional').hide();
                    $('#agregarsw').hide();
                    $('#TblInternacional').hide();

                    for (var i = 1; i <= item; i++) {
                        $('#defaultForm').bootstrapValidator('addField', 'asp_positivos_' + i, {
                            validators: {
                                notEmpty: {
                                    message: 'Fortalezas y aspectos positivos son requeridos'
                                },
                                stringLength: {
                                    max: 2000,
                                    message: 'Fortalezas y aspectos positivos deben contener maximo 2000 caractares'
                                }
                            }
                        });

                        $('#defaultForm').bootstrapValidator('addField', 'oportunidades_mejora_' + i, {
                            validators: {
                                notEmpty: {
                                    message: 'Oportunidades de mejora son requeridos'
                                },
                                stringLength: {
                                    max: 2000,
                                    message: 'Oportunidades de mejora deben contener maximo 2000 caractares'
                                }
                            }
                        });

                        $('#defaultForm').bootstrapValidator('addField', 'aplicaciones_entidad_' + i, {
                            validators: {
                                notEmpty: {
                                    message: 'Aplicaciones para la entidad son requeridos'
                                },
                                stringLength: {
                                    max: 2000,
                                    message: 'Aplicaciones para la entidad deben contener maximo 2000 caractares'
                                }
                            }
                        });
                    }

                    break;
                default:
                    $('#TblAprendizaje').hide();
                    $('#aplicaciones').show();
                    $('#TblNacional').show();
                    $('#agregarsw').show();
                    $('#TblInternacional').hide();
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
                    for (var i = 1; i <= item; i++) {
                        $('#defaultForm').bootstrapValidator('removeField', 'asp_positivos_' + i);
                        $('#defaultForm').bootstrapValidator('removeField', 'oportunidades_mejora_' + i);
                        $('#defaultForm').bootstrapValidator('removeField', 'aplicaciones_entidad_' + i);
                    }
                    break;
            }
        }
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $("#BtnBorrador").click(function () {
        var url = $("#Url").val();
        $.post(url, $("#defaultForm").serialize(), function () {
        })
        .done(function(data, textStatus, jqXHR) {
            $('#mensajeborrador').show(10);
            console.log(data);
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            if (console && console.log) {
                console.log("La solicitud a fallado: " + textStatus);
            }
            $('#mensajeborradorerror').show(10);
        });
    });
    
    function guargar_borrador(){
        var url = $("#Url").val();
        $.post(url, $("#defaultForm").serialize(), function () {
        })
        .done(function(data, textStatus, jqXHR) {
            $('#mensajeborrador').show(10);
            console.log(data);
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            if (console && console.log) {
                console.log("La solicitud a fallado: " + textStatus);
            }
            $('#mensajeborradorerror').show(10);
        });
    }
    
    setInterval(guargar_borrador, 10000);
});

// Adicionar Filas a la tabla de Opciones
function addTableRow(table) {
    var $tr = $(table).find('tr:last').clone();
    $tr.find('input').attr('value', "");
    //$(table).find('tr:last td div input').attr('id', "diego");

    var id_fila = "fila" + eval($(table).find('tr').length + 1);

    var fila = $(table).find('tr:last');
    var n = $(table).find('tr:last td').length;
    var tds = '<tr id="' + id_fila + '"><td>' + $(table).find('tr:last td').html() + '</td>';
    for (var i = 0; i < n - 2; i++) {
        tds += '<td>' + $(table).find('tr:last td:gt(' + i + ')').html() + '</td>';
    }
    // Adicionar la ultina columna
    var fn_click = "removeTableRow('#" + id_fila + "')";

    tds += "<td><button type='button' class='btn btn-default btn-sm ' onclick=" + fn_click + " title='Eliminar el documento adjunto'>Eliminar</button></td>";
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