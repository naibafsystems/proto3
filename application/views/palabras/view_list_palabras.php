<?php if ($this->session->userdata('logueado')) { ?>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li class="active">Analiza las comisiones</li>
    </ol>
    <h1>Analiza las comisiones</h1>
    <div>	
        <p><br />En este espacio tendrás la oportunidad de analizar las actividades, los conocimientos, las experiencias y las lecciones adquiridas durante las comisiones.<br /></p>
    </div>
    <br />
    <!-- Blog Search Well -->
    <form action="<?php echo base_url();?>index.php/Comisiones/buscar_comisiones" method="post" accept-charset="utf-8" class="form-horizontal col-sm-12" autocomplete="on">        
        <div class="form-group">
            <label class="col-sm-2 control-label">Palabras clave</label>
            <div class="col-sm-9 ">
                <div class="input-group">
                    <input type="text" class="form-control" id="palabraClave" name="palabraClave" placeholder="" required="">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit" id="submit" name="submit">Buscar</button>
                    </span>
                </div><!-- /input-group -->
            </div>
        </div>
    </form>   

    <ul class="nav nav-tabs">
        <li id="TabAprendizaje"><a data-toggle="tab" href="#home">Aprendizaje</a></li>
        <li id="TabNacional"><a data-toggle="tab" href="#home">Nacional</a></li>
        <li id="TblInternacional"><a data-toggle="tab" href="#home">Internacional</a></li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <!--<h3>Nube de palabras aprendizaje</h3>-->
            <div class="col-lg-4">
                <button class="btn btn-primary btn-block" type="button" id="Positivos" name="submit">Aspectos positivos</button>
            </div>
            <div class="col-lg-4">
                <button class="btn btn-primary btn-block" type="button" id="Mejorar" name="submit">Aspectos por mejorar</button>
            </div>
            <div class="col-lg-4">
                <button class="btn btn-primary btn-block" type="button" id="Aplicaciones" name="submit">Aplicaciones para la entidad</button>
            </div>
            <br /><br /><br />
            <div class="row">
                <div class="col-lg-6">
                    <select class="form-control" id="CriterioSel">
                        <option value="">Seleccione</option>
                        <option value="1">Participación de los candidatos en el proceso de aprendizaje</option>
                        <option value="2">Cumplimiento de la agenda o de los protocolos de la actividad</option>
                        <option value="3">Comentarios sobre los materiales de aprendizaje y las pruebas de conocimiento (b-learning)</option>
                        <option value="4">Disponibilidad de equipos tecnológicos y funcionamiento de la plataforma de aprendizaje</option>
                        <option value="5">Otras observaciones</option>
                    </select>
                </div>
                <div class="col-lg-6">
                    <div class="nube">
                        <div class="etiquetas">
                            <?php echo $palabras; ?>
                        </div>
                    </div>
                </div>
            </div>
            <br /><br /><br />
            <table class="table table-striped" id="TblComisiones">
                <thead>
                    <th class="col-lg-2 text-center">Lugar</th>
                    <th class="col-lg-2 text-center">Autor</th>
                    <th class="col-lg-7 text-center">Objeto de la comisi&oacute;n</th>
                    <th class="col-lg-1 text-center">Informe</th>
                </thead>
                <tbody>
                    <?php foreach ($listado as $valor){ ?>
                        <?php if($valor->id_datos != null){ ?>
                            <tr>
                                <td>
                                    <?php echo $valor->LUGAR_COMISION; ?><br />
                                    <?php //echo $valor->direccion; ?>
                                </td>
                                <td><?php echo ucwords(mb_strtolower($valor->NOMBRE)); ?><br /><?php echo $valor->mail_usuario; ?></td>
                                <td><?php echo $valor->OBJETO; ?><br />
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#resumen" onclick="carga_ajax('<?php echo base_url();?>index.php/comisiones/resumen','<?php echo $valor->id_datos; ?>','Ver_resumen')">Ver resumen <i title="Adicionar" class="fa fa-info-circle" aria-hidden="true"></i></a>    
                                </td>
                                <td align="center">
                                    <a href="<?php echo base_url();?>index.php/Comisiones/ver/<?php echo $valor->id_datos; ?>" class="" target="_black"><i title="Detalle" class="fa fa-file-text-o fa-2x" aria-hidden="true"></i> </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?> 
                </tbody>
            </table>
            <!--<div id="datos_tbl"></div>-->
        </div>
    </div>

    <form action="<?php echo base_url();?>index.php/palabras/addanalisis" method="post" accept-charset="utf-8" class="form-horizontal col-sm-12" autocomplete="on">
        <input type="hidden" id="ruta" value="<?php echo base_url();?>index.php/palabras/index" />
        <input type="hidden" value="<?php echo $tipo_comi_sel; ?>" id="tipo_comision" name="tipo_comision" />
        <input type="hidden" value="<?php echo $aspecto_sel; ?>" id="aspecto_sel" name="aspecto_sel" />
        <input type="hidden" value="<?php echo $criterio_sel; ?>" id="criterio_sel" name="criterio_sel" />
        <input type="hidden" value="all" id="llave" />
        <input type="hidden" value="datos_tbl" id="salida" />
        <div class="form-group" id="DivAnalisis">    
            <label for="analisis" class="control-label">Análisis</label> <a data-toggle="tooltip" data-placement="top" title="En este espacio podrás escribir un análisis sobre las sugerencias o comentarios a los profesionales responsables de las oportunidades de mejora y lecciones aprendidas descritas en las comisiones para que se tomen las acciones que se consideren pertinentes."><i class="fa fa-question-circle-o " aria-hidden="true"></i></a>
            <textarea class="form-control" value="" required="" id="analisis" rows="3" cols="40" name="analisis" placeholder="En este espacio podrás escribir un análisis sobre las sugerencias o comentarios a los profesionales responsables de las oportunidades de mejora y lecciones aprendidas descritas en las comisiones para que se tomen las acciones que se consideren pertinentes."></textarea>
        </div>
        <div class="form-group col-lg-12">
            <div class="col-lg-5" ></div>
            <div class="form-group col-lg-3" id="DivDestino">    
                <select class="form-control" name="destinatario" id="destinatario" required="">
                    <option value="">Seleccione Destinatario</option>
                    <option value="dasuarezt@dane.gov.co">dasuarezt@dane.gov.co</option>
                    <option value="jpcades@dane.gov.co">jpcades@dane.gov.co</option>
                    <option value="mafonsecap@dane.gov.co">mafonsecap@dane.gov.co</option>
                </select>
            </div>
            <div class="col-lg-1"></div>
            <button name="btn_enviar" class="btn btn-primary col-lg-3" type="submit">Enviar</button>
        </div>
    </form>

    <div class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="resumen">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Resumen</h4>
                </div>
                <div class="modal-body">
                    <div id="Ver_resumen"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<?php }else{ echo redirect(base_url("index.php/login/iniciar_sesion")); } ?>
