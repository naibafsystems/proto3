<?php if ($this->session->userdata('logueado')) { ?>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li class="active">Comisiones</li>
    </ol>
    <h1>Comparte tus comisiones para la gestión del conocimiento</h1><br />
    <div class="alert alert-success alert-dismissible" role="alert" id="mensajeborrador" hidden="">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Exito!</strong> se guardo el borrador correctamente.
    </div>
    <div class="alert alert-danger alert-dismissible" role="alert" id="mensajeborradorerror" hidden="">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Error!</strong> se produjo un error al tratar de guardar el borrador, contacta el administrador.
    </div>
    <div class="well">
        <p><b>Nombre: </b><?php echo ucwords(mb_strtolower($datos_comisiones[0]->NOMBRE)); ?> <b>Número de documento: </b><?php echo $datos_comisiones[0]->NUMERO_DOCUMENTO; ?></p>
        <p><b>Objeto de la comisión: </b><?php echo $datos_comisiones[0]->OBJETO; ?></p>
        <p><b>Fecha de inicio: </b><?php echo $datos_comisiones[0]->FECHA_INICIAL; ?> <b>Fecha de finalización: </b><?php echo $datos_comisiones[0]->FECHA_FINAL; ?></p>
        <p><b>Lugar: </b><?php echo $datos_comisiones[0]->LUGAR_COMISION; ?>&nbsp;&nbsp;&nbsp;<b>Ruta:</b><?php echo $TipoRuta; ?></p>
        <p><b>Tipo comisi&oacute;n: </b><?php
            if ($tipo_comision == 'N') {
                echo 'Nacional';
            } else {
                echo 'Internacional';
            }
            ?></p>
    </div>

    <?php
    $input_com_id = array(
        'id_com' => $datos_comisiones[0]->INTERNO_GEN
    );
    ?>
    <div class="container-fluid">
        <?php //print_r($borrador); ?>
        <?php echo form_open('', 'enctype="multipart/form-data" id="defaultForm"'); ?>
        <?php echo form_hidden($input_com_id); ?>
        <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo_comision; ?>" />
        <div class="row">
            <div class="col-lg-5">
                <div class="form-group" id="DivTema">
                    <label for="tema" class="control-label">Tema</label>
                    <select name="tema" id="tema" required="" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach ($temas as $clave => $valor) { ?>
                            <option value="<?php echo $valor->id_tema; ?>" data-tipotema="<?php echo $valor->tipo_tema; ?>"
                            <?php
                            if (!empty($borrador['tema'])) {
                                if ($borrador['tema'] == $valor->id_tema) {
                                    echo "selected=''";
                                }
                            }
                            ?> >
                                <?php echo $valor->tema; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="form-group" id="DivResumen">
                    <label for="id_resumen" class="control-label">Resumen de la comisión</label>
                    <textarea class="form-control" required="" id="id_resumen" rows="3" cols="40" name="resumen" placeholder="Resumen de la comisión"><?php
                        if (!empty($borrador['resumen'])) {
                            echo $borrador['resumen'];
                        }
                        ?></textarea>
                </div>
                <!--<div class="form-group" id="DivParticipantes">    
                    <label for="id_participantes" class="control-label">Participantes <a data-toggle="tooltip" data-placement="top" title="Ingresa aquí el nombre, correo electrónico y teléfono de las personas con quienes interactuaste en la comisión y que consideres enlaces clave para encuentros posteriores."><i class="fa fa-question-circle-o " aria-hidden="true"></i></a></label>
                    <textarea class="form-control" value="" required="" id="id_participantes" rows="3" cols="40" name="participantes" placeholder="Ingresa aquí las entidades participantes de la actividad o la cantidad de participantes por rol que se presentan a la prueba o al aprendizaje."></textarea>
                </div>-->
                <div class="form-group" id="DivDatosContacto">  
                    <label for="tblcontactos">Datos de contacto <a data-toggle="tooltip" data-placement="top" title="Ingresa aquí el nombre, correo electrónico y teléfono de las personas con quienes interactuaste en la comisión y que consideres enlaces clave para encuentros posteriores."><i class="fa fa-question-circle-o " aria-hidden="true"></i></a></label>
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
                            <td><div class="form-group"><input name="nombre_con[]" id="nombre_con" value="" class="form-control" placeholder="Nombre contacto" /></div></td>
                            <td><div class="form-group"><input name="apellido_con[]" id="apellido_con" value="" class="form-control" placeholder="Apellido contacto" /></div></td>
                            <td><div class="form-group"><input name="cargo_con[]" id="cargo_con" value="" class="form-control" placeholder="Cargo contacto" /></div></td>
                            <td><div class="form-group"><input name="mail_con[]" id="mail_con" value="" class="form-control" placeholder="Correo electronico contacto" /></div></td>
                            <td><div class="form-group"><input name="telefono_con[]" id="telefono_con" value="" class="form-control" placeholder="Telefono contacto" /></div></td>
                            <td><button type="button" class="btn btn-default btn-sm " onclick="addTableRow('#tblcontactos')">Adicionar</button></td>
                        </tr>
                        <?php 
                        if (isset($borrador['nombre_con'])){
                        $CantContactos = count($borrador['nombre_con']); 
                        if($CantContactos > 1){ 
                            $iter = 3;
                            foreach ($borrador['nombre_con'] as $key=>$Valor){ 
                                if ($borrador['nombre_con'][$key] != "" || $borrador['apellido_con'][$key] != "" || $borrador['cargo_con'][$key] != "" || $borrador['mail_con'][$key] != "" || $borrador['telefono_con'][$key] != ""){ ?>
                                <tr id="fila<?php echo $iter; ?>">
                                    <td><div class="form-group"><input name="nombre_con[]" id="nombre_con" value="<?php echo $borrador['nombre_con'][$key]; ?>" class="form-control" placeholder="Nombre contacto"></div></td>
                                    <td><div class="form-group"><input name="apellido_con[]" id="apellido_con" value="<?php echo $borrador['apellido_con'][$key]; ?>" class="form-control" placeholder="Apellido contacto"></div></td>
                                    <td><div class="form-group"><input name="cargo_con[]" id="cargo_con" value="<?php echo $borrador['cargo_con'][$key]; ?>" class="form-control" placeholder="Cargo contacto"></div></td>
                                    <td><div class="form-group"><input name="mail_con[]" id="mail_con" value="<?php echo $borrador['mail_con'][$key]; ?>" class="form-control" placeholder="Correo electronico contacto"></div></td>
                                    <td><div class="form-group"><input name="telefono_con[]" id="telefono_con" value="<?php echo $borrador['telefono_con'][$key]; ?>" class="form-control" placeholder="Telefono contacto"></div></td>
                                    <td><button type="button" class="btn btn-default btn-sm " onclick="removeTableRow('#fila<?php echo $iter; ?>')" title="Eliminar el documento adjunto">Eliminar</button></td>
                                </tr>
                            <?php
                            $iter ++;
                            }
                            }
                        }
                        }
                        ?>
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
                <?php
                foreach ($criterios as $Valor) {
                    $items = $items + 1;
                    ?>
                    <tr>
                        <td><input type="hidden" name="criterio[]" value="<?php echo $Valor->id_criterio; ?>" /><?php echo $Valor->criterio; ?><a data-toggle="tooltip" data-placement="top" title="<?php echo $Valor->ayuda; ?>"><i class="fa fa-question-circle-o " aria-hidden="true"></i></a></td>
                        <td><div class="form-group"><textarea id="asp_positivos_<?php echo $Valor->id_criterio; ?>" name="asp_positivos_<?php echo $Valor->id_criterio; ?>" data-toggle="tooltip" data-placement="top" class="form-control" value=""  rows="4" cols="40" placeholder="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" title="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio"><?php if (!empty($borrador['asp_positivos_'.$Valor->id_criterio])){ echo $borrador['asp_positivos_'.$Valor->id_criterio]; } ?></textarea></div></td>
                        <td><div class="form-group"><textarea id="oportunidades_mejora_<?php echo $Valor->id_criterio; ?>" name="oportunidades_mejora_<?php echo $Valor->id_criterio; ?>" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="4" cols="40" placeholder="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." title="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." ><?php if (!empty($borrador['oportunidades_mejora_'.$Valor->id_criterio])){ echo $borrador['oportunidades_mejora_'.$Valor->id_criterio]; } ?></textarea></div></td>
                        <td><div class="form-group"><textarea id="aplicaciones_entidad_<?php echo $Valor->id_criterio; ?>" name="aplicaciones_entidad_<?php echo $Valor->id_criterio; ?>" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="4" cols="40" placeholder="Describe en este apartado la forma en que pueden aplicarse las oportunidades de mejora en la entidad, evidenciados en el proceso de observación del aprendizaje/prueba." title="Describe en este apartado la forma en que pueden aplicarse las oportunidades de mejora en la entidad, evidenciados en el proceso de observación del aprendizaje/prueba." ><?php if (!empty($borrador['aplicaciones_entidad_'.$Valor->id_criterio])){ echo $borrador['aplicaciones_entidad_'.$Valor->id_criterio]; } ?></textarea></div></td>
                    </tr>
                <?php } ?>
            <input type="hidden" id="items" name="items" value="<?php echo $items = $items - 1; ?>" />
            </tbody>
        </table>
        <input type="button" id="agregarsw" class="btn btn-default" value="Agregar actividad" />
        <table class="table table-hover" id="TblNacional">
            <thead>
            <th class="col-sm-4">Actividades desarrolladas</th>
            <th class="col-sm-4">Fortalezas y aspectos positivos</th>
            <th class="col-sm-3">Oportunidades de mejora</th>
            <th class="col-sm-1">Nueva actividad</th>
            </thead>
            <tbody>
                <tr class="fila-base-sw">
                    <td><div class="form-group"><textarea id="nal_actdesarro" name="nal_actdesarro[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Actividades desarrolladas" title="Actividades desarrolladas" ></textarea></div></td>
                    <td><div class="form-group"><textarea id="nal_positivos" name="nal_positivos[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" title="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" ></textarea></div></td>
                    <td><div class="form-group"><textarea id="nal_dificultades" name="nal_dificultades[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." title="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." ></textarea>	</div></td>
                    <!--<td><button type="button" class="btn btn-default btn-sm " onclick="addTableRow('#TblNacional')">Adicionar</button></td>-->
                    <td class="eliminarsw btn btn-default btn-sm">Eliminar</td>
                </tr>
                <?php 
                if (isset($borrador['nombre_con'])){
                    $CantContactos = count($borrador['nal_actdesarro']); 
                    if($CantContactos > 0){ 
                        foreach ($borrador['nal_actdesarro'] as $key=>$Valor){ 
                            if ($borrador['nal_actdesarro'][$key] != "" || $borrador['nal_positivos'][$key] != "" || $borrador['nal_dificultades'][$key] != ""){ ?>
                            <tr>
                                <td><div class="form-group"><textarea id="nal_actdesarro" name="nal_actdesarro[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Actividades desarrolladas" title="Actividades desarrolladas" ><?php echo $borrador['nal_actdesarro'][$key]; ?></textarea></div></td>
                                <td><div class="form-group"><textarea id="nal_positivos" name="nal_positivos[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" title="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" ><?php echo $borrador['nal_positivos'][$key]; ?></textarea></div></td>
                                <td><div class="form-group"><textarea id="nal_dificultades" name="nal_dificultades[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." title="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." ></textarea>	</div></td>
                                <!--<td><button type="button" class="btn btn-default btn-sm " onclick="addTableRow('#TblNacional')">Adicionar</button></td>-->
                                <td class="eliminarsw btn btn-default btn-sm">Eliminar</td>
                            </tr>
                        <?php
                            }
                        }
                    }else{
                    ?>
                        <tr>
                            <td><div class="form-group"><textarea id="nal_actdesarro" name="nal_actdesarro[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Actividades desarrolladas" title="Actividades desarrolladas" ></textarea></div></td>
                            <td><div class="form-group"><textarea id="nal_positivos" name="nal_positivos[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" title="Escribe los aspectos positivos y las fortalezas que identificaste con respecto a cada criterio" ></textarea></div></td>
                            <td><div class="form-group"><textarea id="nal_dificultades" name="nal_dificultades[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." title="Describe las lecciones aprendidas y las oportunidades de mejora que hallaste con respecto a cada criterio y que servirían para mejorar la calidad del proceso de aprendizaje." ><?php echo $borrador['nal_dificultades'][$key]; ?></textarea>	</div></td>
                            <!--<td><button type="button" class="btn btn-default btn-sm " onclick="addTableRow('#TblNacional')">Adicionar</button></td>-->
                            <td class="eliminarsw btn btn-default btn-sm">Eliminar</td>
                        </tr>
                <?php } } ?>
            </tbody>
        </table>
        
        <table class="table table-hover" id="TblInternacional">
            <thead>
            <th class="col-sm-4">Temas tratados</th>
            <th class="col-sm-4">Fortalezas y aspectos positivos</th>
            <th class="col-sm-4">Oportunidades de mejora</th>
            </thead>
            <tbody>
                <tr>
                    <td><div class="form-group"><textarea id="temas_tra" name="temas_tra[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Temas tratados" title="Temas tratados" ></textarea></div></td>
                    <td><div class="form-group"><textarea id="lecciones" name="lecciones[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Fortalezas y aspectos positivos" title="Fortalezas y aspectos positivos" ></textarea></div></td>
                    <td><div class="form-group"><textarea id="oportunidades" name="oportunidades[]" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Oportunidades de mejora" title="Oportunidades de mejora" ></textarea></div></td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-10">
                <div class="form-group" id="aplicaciones" >
                    <label for="aplicaciones" class="control-label">Aplicaciones para la entidad</label>
                    <textarea id="aplicaciones" name="aplicaciones" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Describe en este apartado la forma en que pueden aplicarse las oportunidades de mejora en la entidad, evidenciados durante la comisión." title="Describe en este apartado la forma en que pueden aplicarse las oportunidades de mejora en la entidad, evidenciados durante la comisión." ><?php
                        if (!empty($borrador['aplicaciones'])) {
                            echo $borrador['aplicaciones'];
                        }
                        ?></textarea>
                </div>
                <div class="form-group" >
                    <label for="conclusiones" class="control-label">Recomendaciones o sugerencias</label>
                    <textarea id="conclusiones" name="conclusiones" data-toggle="tooltip" data-placement="top" class="form-control" value="" rows="3" cols="40" placeholder="Recomendaciones o sugerencias" title="Recomendaciones o sugerencias" ><?php
                        if (!empty($borrador['conclusiones'])) {
                            echo $borrador['conclusiones'];
                        }
                        ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10">
                <input type="hidden" name="RutaA" id="RutaA" value="<?php echo $RutaA; ?>" />
                <input type="hidden" name="RutaT" id="RutaB" value="<?php echo $RutaT; ?>" />
                <input type="hidden" name="RutaO" id="RutaO" value="<?php echo $RutaO; ?>" />

    <?php if ($RutaA != "") { ?>
                    <div class="form-group">
                        <label for="pasabordo" class="control-label">Pasabordos</label>
                        <input type="file" id="pasabordo" name="pasabordo" class="form-control" />
                    </div>
    <?php } ?>
    <?php if ($RutaT != "") { ?>
                    <div class="form-group">
                        <label for="tiquete" class="control-label">Tiquetes terrestres</label>
                        <input type="file" id="tiquete" name="tiquete" class="form-control" />
                    </div>
    <?php } ?>
    <?php if ($RutaO != "") { ?>
                    <div class="form-group">
                        <label for="otraruta" class="control-label">Otra ruta</label>
                        <input type="file" id="tiquete" name="otraruta" class="form-control" />
                    </div>
    <?php } ?>
                <div class="form-group">
                    <label for="certificadoper" class="control-label">Certificado de permanencia</label>
                    <input type="file" id="certificadoper" name="certificadoper" class="form-control" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10">
                <table class="col-lg-12 table table-hover" id="tblarchivos">
                    <thead>
                    <th class="col-lg-2">Tipo anexo</th>                    
                    <th class="col-lg-4">Anexo</th>
                    <th class="col-lg-5">Descripci&oacute;n anexo</th>
                    <th class="col-lg-2">Acci&oacute;n</th>
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
            </div>
        </div>
        <br />
        <input type="hidden" name="Url" id="Url" value="<?php echo base_url("index.php/Borrador/borrador"); ?>" />
        <input type="hidden" name="interno_gen" id="interno_gen" value="<?php echo $interno_gen; ?>" />
        <input type="hidden" name="interno_enc" id="interno_enc" value="<?php echo $interno_enc; ?>" />
        <input type="hidden" name="vigencia" id="vigencia" value="<?php echo $vigencia; ?>" />
        <input type="hidden" name="cod_unidad" id="cod_unidad" value="<?php echo $cod_unidad; ?>" />
        <button name="btn_borrador" class="btn btn-info" type="button" id="BtnBorrador">Guardar borrador</button>
        <button name="btn_enviar" class="btn btn-primary" type="submit">Guardar</button>
    <?php echo form_close(); ?>
    </div>
    <?php
} else {
    echo redirect(base_url("index.php/login/iniciar_sesion"));
}
?>