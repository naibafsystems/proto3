<?php if ($this->session->userdata('logueado')) { ?>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li class="active">Conoce las comisiones de otros</li>
    </ol>
    <h1>Conoce las comisiones de otros</h1>
    <div>	
        <p><br />En este espacio tendrás la oportunidad de conocer las actividades, los conocimientos, las experiencias y las lecciones aprendidas  obtenidas por tus compañeros durante las comisiones realizadas tanto a nivel nacional como internacional.<br /></p>
    </div>
    <br />
    <!-- Blog Search Well -->
    <form action="<?php echo base_url(); ?>index.php/Comisiones/buscar_comisiones" method="post" accept-charset="utf-8" class="form-horizontal col-sm-12" autocomplete="on">        
        <div class="form-group">
            <label class="col-sm-2 control-label">&nbsp;</label>
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
    <?php //print_r($this->session->userdata); ?>
    <!--Tienes <?php echo count($listado); ?> Comisiones-->
    <br /><br /><br />
    <table class="table table-striped" id="TblComisiones">
        <thead>
        <th class="td-ancho-16 text-center">Lugar</th>
        <th class="text-center">Datos de contacto</th>
        <th class="td-ancho-9 text-center">Fecha de inicio</th>
        <th class="td-ancho-9 text-center">Fecha de finalización</th>
        <th class="text-center">Objeto de la comisi&oacute;n</th>
        <th class="td-ancho-9 text-center">Informe</th>
    </thead>
    <tbody>
        <?php foreach ($listado as $valor) { ?>
            <?php if ($valor->id_datos != null) { ?>
                <tr>
                    <td>
                        <?php if ($valor->id_lugar != null) { ?>
                                <!--<a href="javascript:void(0);" data-toggle="modal" data-target="#mapa" onclick="carga_ajax('<?php echo base_url(); ?>index.php/comisiones/viewmapa','<?php echo $valor->id_lugar; ?>','Ver_mapa')"><i title="Ver ubicaci&oacute;n" class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>-->
                        <?php } else { ?> 
                                <!--<a href="#agregarmapa" id="AddMapa" data-idmapa = "<?php echo $valor->LUGAR_COMISION; ?>" data-toggle="modal" data-target="#agregarmapa" data-placement="top"><i title="Agregar ubicaci&oacute;n" class="fa fa-plus-square-o fa-2x" aria-hidden="true"></i></a>-->
                        <?php } ?>
                        <a href="<?php echo base_url(); ?>index.php/comisiones/mapa/<?php echo $valor->id_datos . "/" . $valor->LUGAR_COMISION . "/comi/" . $valor->id_lugar; ?>" ><i title="Ver ubicaci&oacute;n" class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>
                        <?php echo $valor->LUGAR_COMISION; ?><br />
                        <?php echo $valor->direccion; ?>
                    </td>
                    <td><?php echo ucwords(mb_strtolower($valor->NOMBRE)); ?><br /><?php echo $valor->mail_usuario; ?></td>
                    <td><?php echo $valor->FECHA_INICIAL; ?></td>
                    <td><?php echo $valor->FECHA_FINAL; ?></td>
                    <td><?php echo $valor->OBJETO; ?><br />
                        <a href="#" data-toggle="modal" data-target="#resumen" onclick="carga_ajax('<?php echo base_url(); ?>index.php/Comisiones/resumen', '<?php echo $valor->id_datos; ?>', 'Ver_resumen')">Ver resumen <i title="Adicionar" class="fa fa-info-circle" aria-hidden="true"></i></a>    
                        <!--<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#resumen" data-whatever="<?php echo $valor->id_datos; ?>" >Launch demo modal</button>-->
                    </td>
                    <td align="center">
                        <a href="<?php echo base_url(); ?>index.php/Comisiones/ver/<?php echo $valor->id_datos; ?>" class=""><i title="Detalle" class="fa fa-file-text-o fa-2x" aria-hidden="true"></i> </a>
                        <?php if($this->session->userdata('admin')){ ?>
                            <a href="<?php echo base_url(); ?>index.php/Comisiones/editar/<?php echo $valor->id_datos . "/" . $valor->tipo_comi; ?>" class=""><i title="Editar" class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?> 
    </tbody>
    </table>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="mapa">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ubicación</h4>
                </div>
                <div class="modal-body">
                    <div class="text-center" id="Ver_mapa">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="resumen">
        <div class="modal-dialog modal-lg">
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
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="agregarmapa">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Agregar ubicaci&oacute;n</h4>
                </div>
                <form class="form-signin" method="post" action="<?php echo site_url("comisiones/addmapa"); ?>">
                    <div class="modal-body">		
                        <div class="form-group" >
                            <label for="lugar" >Lugar</label>
                            <input type="text" id="lugar" name="lugar" class="form-control" placeholder="Lugar" readonly="" >
                        </div>
                        <div class="form-group" >
                            <label for="direccion" >Direcci&oacute;n</label>
                            <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección" required autofocus />
                        </div>
                        <div class="form-group" >
                            <label for="mapa" >Mapa</label>
                            <input type="text" id="mapa" name="mapa" class="form-control" placeholder="Mapa" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnIngresar" name="btnIngresar" class="btn btn-primary ">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } else {
    echo redirect(base_url("index.php/login/iniciar_sesion"));
} ?>
