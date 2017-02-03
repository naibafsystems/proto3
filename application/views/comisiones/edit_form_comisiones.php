<?php if ($this->session->userdata('logueado')) { ?>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li class="active">Comisiones</li>
    </ol>
    <h1>Comparte tus comisiones para la gestión del conocimiento</h1><br />
    <?php if ($error == "Exito") { ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Exito!</strong> se actualizo correctamente el archivo.
        </div>
    <?php } ?>
    <div class="well">
        <p><b>Nombre: </b><?php echo ucwords(mb_strtolower($datos_comisiones[0]->NOMBRE)); ?> <b>Número de documento: </b><?php echo $datos_comisiones[0]->NUMERO_DOCUMENTO; ?></p>
        <p><b>Objeto de la comisión: </b><?php echo $datos_comisiones[0]->OBJETO; ?></p>
        <p><b>Fecha de inicio: </b><?php echo $datos_comisiones[0]->FECHA_INICIO; ?> <b>Fecha de finalización: </b><?php echo $datos_comisiones[0]->FECHA_TERMINACION; ?></p>
        <p><b>Lugar: </b><?php echo $datos_comisiones[0]->LUGAR_COMISION; ?>&nbsp;&nbsp;&nbsp;<b>Ruta:</b></p>
        <p><b>Tipo comisi&oacute;n: </b><?php
            if ($tipo_comision == 'N') {
                echo 'Nacional';
            } else {
                echo 'Internacional';
                ;
            }
            ?></p>
    </div>

    <div class="container-fluid">
        <?php echo form_open('', 'enctype="multipart/form-data" id="defaultForm"'); ?>
        <input type="hidden" name="id_datos" id="id_datos" value="<?php echo $datos_comisiones[0]->id_datos; ?>" />
        <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo_comision; ?>" />
        <input type="hidden" name="actualizaciones" id="actualizaciones" value="<?php echo $datos_comisiones[0]->actualizaciones; ?>" />
        <div class="row">
            <div class="col-lg-5">
                <div class="form-group" id="DivTema">
                    <label for="tema" class="control-label">Tema</label>
                    <select name="tema" id="tema" required="" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach ($temas as $clave => $valor) { ?>
                            <option value="<?php echo $valor->id_tema; ?>" data-tipotema="<?php echo $valor->tipo_tema; ?>" <?php
                            if ($datos_comisiones[0]->id_tema == $valor->id_tema) {
                                echo "selected=''";
                            }
                            ?> > <?php echo $valor->tema; ?></option>
                                <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="form-group" id="DivResumen">
                    <label for="id_resumen" class="control-label">Resumen de la comisión</label>
                    <textarea class="form-control" value="" required="" id="id_resumen" rows="3" cols="40" name="resumen" placeholder="Resumen de la comisión"><?php echo $datos_comisiones[0]->resumen_comision; ?></textarea>
                </div>
                <!--<div class="form-group" id="DivParticipantes">    
                    <label for="id_participantes" class="control-label">Participantes <a data-toggle="tooltip" data-placement="top" title="Ingresa aquí el nombre, correo electrónico y teléfono de las personas con quienes interactuaste en la comisión y que consideres enlaces clave para encuentros posteriores."><i class="fa fa-question-circle-o " aria-hidden="true"></i></a></label>
                    <textarea class="form-control" value="" required="" id="id_participantes" rows="3" cols="40" name="participantes" placeholder="Ingresa aquí las entidades participantes de la actividad o la cantidad de participantes por rol que se presentan a la prueba o al aprendizaje."><?php echo $datos_comisiones[0]->participantes; ?></textarea>
                </div>-->                       
                <div class="form-group" id="DivDatosContacto">  
                    <label>Datos de contacto <a data-toggle="tooltip" data-placement="top" title="Ingresa aquí el nombre, correo electrónico y teléfono de las personas con quienes interactuaste en la comisión y que consideres enlaces clave para encuentros posteriores."><i class="fa fa-question-circle-o " aria-hidden="true"></i></a></label>
                    <table class="table table-striped table-bordered" id="TblArchivos">
                        <thead>
                        <th class="text-center col-lg-2">Nombre</th>
                        <th class="text-center col-lg-2">Apellido</th>
                        <th class="text-center col-lg-2">Cargo</th>
                        <th class="text-center col-lg-2">Correo electrónico</th>
                        <th class="text-center col-lg-2">Tel&eacute;fono</th>
                        <th class="text-center col-lg-2">Acci&oacute;n</th>
                        </thead>
                        <tbody>
                            <?php if ($contactos == null) { ?>
                                <tr>
                                    <td class="text-center" colspan="6  ">No se encontrar&oacute;n contactos para esta comisi&oacute;n</td>
                                </tr>
                            <?php } ?>
                            <?php foreach ($contactos as $valor) { ?>
                                <tr>
                                    <td><?php echo $valor->nombre; ?></td>
                                    <td><?php echo $valor->apellido; ?></td>
                                    <td><?php echo $valor->cargo; ?></td>
                                    <td><?php echo $valor->mail; ?></td>
                                    <td><?php echo $valor->telefono; ?></td>
                                    <td class="text-center">
                                        <a href="#editarcontacto" id="EditContacto" data-toggle="modal" data-target="#editarcontacto" data-placement="top" data-idcontacto = "<?php echo $valor->id_contacto; ?>" data-nombre = "<?php echo $valor->nombre; ?>" data-apellido = "<?php echo $valor->apellido; ?>" data-cargo = "<?php echo $valor->cargo; ?>" data-mail = "<?php echo $valor->mail; ?>" data-telefono = "<?php echo $valor->telefono; ?>" class=""><i title="Editar Contacto" class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i> </a>
                                        <a href="#borrarcontacto" id="DeleteContacto" data-toggle="modal" data-target="#borrarcontacto" data-placement="top" data-idcontacto = "<?php echo $valor->id_contacto; ?>" data-nombre = "<?php echo $valor->nombre; ?>" data-apellido = "<?php echo $valor->apellido; ?>" data-cargo = "<?php echo $valor->cargo; ?>" data-mail = "<?php echo $valor->mail; ?>" data-telefono = "<?php echo $valor->telefono; ?>" class=""><i title="Borrar Contacto" class="fa fa-trash-o fa-2x" aria-hidden="true"></i> </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <table class="col-lg-12 table table-hover" id="tblcontactos">
                        <thead>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Cargo</th>
                        <th>Correo electrónico</th>
                        <th>Teléfono</th>
                        <th></th>
                        </thead>
                        <tr id="fila1">
                            <td><div class="form-group"><input name="nombre_con[]" id="nombre_con" value="" class="form-control" /></div></td>
                            <td><div class="form-group"><input name="apellido_con[]" id="apellido_con" value="" class="form-control" /></div></td>
                            <td><div class="form-group"><input name="cargo_con[]" id="cargo_con" value="" class="form-control" /></div></td>
                            <td><div class="form-group"><input name="mail_con[]" id="mail_con" value="" class="form-control" /></div></td>
                            <td><div class="form-group"><input name="telefono_con[]" id="telefono_con" value="" class="form-control" /></div></td>
                            <td><button type="button" class="btn btn-default btn-sm " onclick="addTableRow('#tblcontactos')">Adicionar</button></td>
                        </tr>
                    </table>  
                </div>
            </div>
        </div>
        <table class="table table-hover" id="TblAprendizaje">
            <thead>
            <th class="text-center col-sm-3">Criterios</th>
            <th class="text-center col-sm-3">Fortalezas y aspectos positivos</th>
            <th class="text-center col-sm-3">Oportunidades de mejora</th>
            <th class="text-center col-sm-3">Aplicaciones para la entidad</th>
            </thead>
            <tbody>
                <?php $items = 0; ?>
                <?php foreach ($datos_comisiones as $Valor) { $items = $items + 1; ?>
                    <tr>
                        <td><input type="hidden" name="id_asp_ap[]" value="<?php echo $Valor->id_aspecto_ap; ?>" /><?php echo $Valor->criterio; ?><a data-toggle="tooltip" data-placement="top" title="<?php echo $Valor->ayuda; ?>"><i class="fa fa-question-circle-o " aria-hidden="true"></i></a></td>
                        <td><div class="form-group"><textarea id="asp_positivos_<?php echo $Valor->id_criterio; ?>" name="asp_positivos[]" data-toggle="tooltip" data-placement="top" class="form-control" value=""  rows="4" cols="40" placeholder="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" title="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio"><?php echo $Valor->fortalezas_ap ?></textarea></div></td>
                        <td><div class="form-group"><textarea id="oportunidades_mejora_<?php echo $Valor->id_criterio; ?>" name="oportunidades_mejora[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="4" cols="40" placeholder="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." title="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." ><?php echo $Valor->oportunidades_ap ?></textarea></div></td>
                        <td><div class="form-group"><textarea id="aplicaciones_entidad_<?php echo $Valor->id_criterio; ?>" name="aplicaciones_entidad[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="4" cols="40" placeholder="Describe en este apartado la forma en que pueden aplicarse las oportunidades de mejora en la entidad, evidenciados en el proceso de observación del aprendizaje/prueba." title="Describe en este apartado la forma en que pueden aplicarse las oportunidades de mejora en la entidad, evidenciados en el proceso de observación del aprendizaje/prueba." ><?php echo $Valor->aplicaciones_ap ?></textarea></div></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <input type="button" id="agregarsw" class="btn btn-default" value="Agregar actividad" />
        <table class="table table-hover" id="TblNacional">
            <thead>
            <th class="col-sm-4">Actividades desarrolladas</th>
            <th class="col-sm-4">Fortalezas y aspectos positivos</th>
            <th class="col-sm-3">Oportunidades de mejora</th>
            <th class="col-sm-1">Acción</th>
            </thead>
            <tbody>
                <tr class="fila-base-sw">
                    <input type="hidden" name="id_asp_ot[]" value="new" />
                    <td><div class="form-group"><textarea id="nal_actdesarro" name="nal_actdesarro[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Actividades desarrolladas" title="Actividades desarrolladas" ></textarea></div></td>
                    <td><div class="form-group"><textarea id="nal_positivos" name="nal_positivos[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" title="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" ></textarea></div></td>
                    <td><div class="form-group"><textarea id="nal_dificultades" name="nal_dificultades[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." title="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." ></textarea>	</div></td>
                    <td class="eliminarsw btn btn-default btn-sm">Eliminar</td>
                </tr>
                <?php foreach ($datos_comisiones as $Aspecto) { ?>
                    <input type="hidden" name="id_asp_ot[]" value="<?php echo $Aspecto->id_aspecto_ot ?>" />
                    <tr>
                        <td><div class="form-group"><textarea id="nal_actdesarro" name="nal_actdesarro[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Actividades desarrolladas" title="Actividades desarrolladas" ><?php echo $Aspecto->actividades_desarrolladas_ot ?></textarea></div></td>
                        <td><div class="form-group"><textarea id="nal_positivos" name="nal_positivos[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" title="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" ><?php echo $Aspecto->fortalezas_asp_positivos_ot ?></textarea></div></td>
                        <td><div class="form-group"><textarea id="nal_dificultades" name="nal_dificultades[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." title="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." ><?php echo $Aspecto->oportunidades_mejora_ot ?></textarea></div></td>
                        <!--<td class="btn btn-default btn-sm">Eliminar</td>-->
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <table class="table table-hover" id="TblInternacional">
            <thead>
            <th class="col-sm-4">Temas tratados</th>
            <th class="col-sm-4">Fortalezas y aspectos positivos</th>
            <th class="col-sm-4">Oportunidades de mejora</th>
            </thead>
            <tbody>
                <?php foreach ($datos_comisiones as $Aspecto) { ?>
                    <input type="hidden" name="id_asp_oti[]" value="<?php echo $Aspecto->id_aspecto_ot ?>" />
                    <tr>
                        <td><div class="form-group"><textarea id="temas_tra" name="nal_actdesarro[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Actividades desarrolladas" title="Actividades desarrolladas" ><?php echo $Aspecto->actividades_desarrolladas_ot ?></textarea></div></td>
                        <td><div class="form-group"><textarea id="lecciones" name="nal_positivos[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" title="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" ><?php echo $Aspecto->fortalezas_asp_positivos_ot ?></textarea></div></td>
                        <td><div class="form-group"><textarea id="oportunidades" name="nal_dificultades[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." title="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." ><?php echo $Aspecto->oportunidades_mejora_ot ?></textarea></div></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-10">
                <div class="form-group" id="aplicaciones" >
                    <label for="aplicaciones" class="control-label">Aplicaciones para la entidad</label>
                    <textarea id="aplicaciones" name="aplicaciones" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Describe en  este apartado la forma en que puede aplicarse los  las fortalezas y aspectos positivos o las oportunidades de mejora evidenciados durante  el desarrollo de la observación del aprendizaje o la prueba." title="Describe en  este apartado la forma en que puede aplicarse los  las fortalezas y aspectos positivos o las oportunidades de mejora evidenciados durante  el desarrollo de la observación del aprendizaje o la prueba." ><?php echo $datos_comisiones[0]->aplicaciones_entidad; ?></textarea>
                </div>
                <div class="form-group" >
                    <label for="conclusiones" class="control-label">Recomendaciones o sugerencias</label>
                    <textarea id="conclusiones" name="conclusiones" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Recomendaciones o sugerencias" title="Recomendaciones o sugerencias" ><?php echo $datos_comisiones[0]->recomendaciones; ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10">
                <table class="table table-striped table-bordered">
                    <thead>
                    <th class="text-center col-lg-4">Nombre archivo</th>
                    <th class="text-center col-lg-6">Resumen</th>
                    <th class="text-center col-lg-2">Acci&oacute;n</th>
                    </thead>
                    <tbody>
                        <?php if ($archivos == null) { ?>
                            <tr>
                                <td class="text-center" colspan="3">No se encontrar&oacute;n documentos anexos</td>
                            </tr>
                        <?php } ?>
                        <?php foreach ($archivos as $valor) { ?>
                            <tr>
                                <td><?php echo $valor->archivo; ?></td>
                                <td><?php echo $valor->resumen_archivo; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo $valor->archivo_ruta . "/" . $valor->archivo; ?>" title="Descargar anexo" target="_blank"><i class="fa fa-download fa-2x" aria-hidden="true"></i></a>
                                    <a href="#" id="DeleteArchivo" data-idarchivo = "<?php echo $valor->id_archivo; ?>" data-rutasvr = "<?php echo base_url('index.php'); ?>" data-tipocomi = "<?php echo $tipo_comision; ?>"><i title="Borrar Contacto" class="fa fa-trash-o fa-2x" aria-hidden="true"></i> </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <table class="col-lg-12 table table-striped" id="tblarchivos">
                    <thead>
                    <th class="col-lg-2 text-center">Tipo anexo</th>
                    <th class="col-lg-4 text-center">Anexo</th>
                    <th class="col-lg-5 text-center">Descripci&oacute;n anexo</th>
                    <th class="col-lg-2 text-center">Acci&oacute;n</th>
                    </thead>
                    <tr id="fila1">
                        <td>
                            <div class="form-group">
                                <select name="tipo_anexo[]" id="tipo_anexo" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <option value="presentaciones">Presentaciones</option>
                                    <option value="video">Video</option>
                                    <option value="imagenes">Imágenes</option>
                                    <option value="documentos">Documentos (Word, Excel, PDF)</option>
                                </select>
                            </div>
                        </td>
                        <td><div class="form-group"><input class="form-control" type="file" name="archivo[]" id="archivo" value="" title="Seleccione" /></div></td>
                        <td><div class="form-group"><textarea name="resumen_archivo[]" cols="40" rows="3" id="resumen_archivo" value="" class="form-control"></textarea></div></td>
                        <td><button type="button" class="btn btn-default btn-sm " onclick="addTableRow('#tblarchivos')">Adjuntar otro</button></td>
                    </tr>
                </table>
                <?php if (($datos_comisiones[0]->com_administradores_id == $this->session->userdata('id_user')) || ($this->session->userdata('admin'))) { ?>
                    <br />
                    <h3>Documentos legalización</h3>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th class="text-center col-lg-5">Nombre archivo</th>
                            <th class="text-center col-lg-5">Tipo documento</th>
                            <th class="text-center col-lg-2">Acción</th>
                        </thead>
                        <tbody>
                            <?php if ($archivos_ruta == null) { ?>
                                <tr>
                                    <td class="text-center" colspan="3">No se encontrar&oacute;n documentos anexos</td>
                                </tr>
                            <?php } ?>
                            <?php foreach ($archivos_ruta as $valor) { ?>
                                <tr>
                                    <td><?php echo $valor->archivo; ?></td>
                                    <td><?php 
                                             switch ($valor->tipo_ruta){
                                                case "A":
                                                    echo "Pasabordos";
                                                    break;
                                                case "T":
                                                    echo "Tiquetes terrestres";
                                                    break;
                                                case "C":
                                                    echo "Certificado Permanencia";
                                                    break;
                                                default :
                                                    echo "Otro";
                                                    break;
                                             }
                                    ?></td>
                                    <td class="text-center">
                                        <a href="#editfileleg" id="EditFileLeg" data-toggle="modal" data-target="#editfileleg" data-placement="top" data-idfile = "<?php echo $valor->id_ruta; ?>" data-tipo="<?php echo $valor->tipo_ruta; ?>" data-nomfile="<?php echo $valor->archivo; ?>" class=""><i title="Editar Archivo" class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i> </a>
                                        <a href="<?php echo $valor->archivo_ruta . "/" . $valor->archivo; ?>" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
        <br />
        <button name="btn_enviar" class="btn btn-primary" type="submit">Guardar</button>
        <?php //echo form_submit('btn_enviar','Guardar', 'class="btn btn-primary"')    ?>
        <?php echo form_close(); ?>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="editfileleg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar contacto</h4>
                </div>
                <form id="Formeditfile" class="form-signin" enctype="multipart/form-data" method="post" action="<?php echo base_url("index.php/comisiones/edit_file_legalizacion"); ?>">
                    <input type="hidden" name="iddatosedit" id="iddatosedit" value="<?php echo $datos_comisiones[0]->id_datos; ?>" />
                    <input type="hidden" name="tipocomision" id="tipocomision" value="<?php echo $tipo_comision; ?>" />
                    <input type="hidden" id="IdFileNew" name="IdFileNew" value="" />
                    <input type="hidden" id="TipFile" name="TipFile" value="" />
                    <div class="modal-body">	
                        <div class="form-group">
                            <label for="newfile" class="control-label">Archivo a actualizar:</label>
                            <div id="fileold"></div>
                        </div>
                        <div class="form-group">
                            <label for="newfile" class="control-label" id="TituloForm"></label>
                            <input type="file" id="newfile" name="newfile" class="form-control" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn_enviar" name="btn_enviar" class="btn btn-primary ">Actualizar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="editarcontacto">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar contacto</h4>
                </div>
                <form class="form-signin" method="post" action="<?php echo site_url("comisiones/edit_contacto"); ?>">
                    <input type="hidden" id="idcontacto_edit" name="idcontacto_edit" />
                    <input type="hidden" id="id_datos_edit" name="id_datos_edit" value="<?php echo $datos_comisiones[0]->id_datos; ?>" />
                    <div class="modal-body">		
                        <div class="form-group" >
                            <label for="nombre_edit" >Nombre</label>
                            <input type="text" id="nombre_edit" name="nombre_edit" class="form-control" placeholder="Nombre" required="" autofocus />
                        </div>
                        <div class="form-group" >
                            <label for="apellido_edit" >Apellido</label>
                            <input type="text" id="apellido_edit" name="apellido_edit" class="form-control" placeholder="Apellido" required="" />
                        </div>
                        <div class="form-group" >
                            <label for="cargo_edit" >Cargo</label>
                            <input type="text" id="cargo_edit" name="cargo_edit" class="form-control" placeholder="Cargo" required="" />
                        </div>
                        <div class="form-group" >
                            <label for="mail_edit" >Correo electronico</label>
                            <input type="text" id="mail_edit" name="mail_edit" class="form-control" placeholder="Correo electronico" required="" />
                        </div>
                        <div class="form-group" >
                            <label for="telefono_edit" >Tel&eacute;fono</label>
                            <input type="text" id="telefono_edit" name="telefono_edit" class="form-control" placeholder="Tel&eacute;fono" required="" />
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn_enviar" name="btn_enviar" class="btn btn-primary ">Actualizar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="borrarcontacto">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Borrar contacto</h4>
                </div>
                <form class="form-signin" enctype="multipart/form-data" method="post" action="<?php echo site_url("comisiones/delete_contacto"); ?>">
                    <input type="hidden" id="idcontacto_delete" name="idcontacto_delete" />
                    <input type="hidden" id="id_datos_delete" name="id_datos_delete" value="<?php echo $datos_comisiones[0]->id_datos; ?>" />
                    <div class="modal-body">		
                        <b>Desea continuar con la eliminacion del siguiente contacto?</b><br /><br />
                        <div class="form-group" >
                            <label for="nombre_delete" >Nombre</label>
                            <div id="nombre_delete"></div>
                        </div>
                        <div class="form-group" >
                            <label for="apellido_delete" >Apellido</label>
                            <div id="apellido_delete"></div>
                        </div>
                        <div class="form-group" >
                            <label for="cargo_delete" >Cargo</label>
                            <div id="cargo_delete"></div>
                        </div>
                        <div class="form-group" >
                            <label for="mail_delete" >Correo Electronico</label>
                            <div id="mail_delete"></div>
                        </div>
                        <div class="form-group" >
                            <label for="telefono_delete" >Telefono</label>
                            <div id="telefono_delete"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn_enviar" name="btn_enviar" class="btn btn-danger ">Eliminar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
} else {
    echo redirect(base_url("index.php/login/iniciar_sesion"));
}
?>