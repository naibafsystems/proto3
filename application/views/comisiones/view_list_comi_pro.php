<?php if ($this->session->userdata('logueado')) { ?>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li class="active">Comparte tu comisión</li>
    </ol>
    <h1>Comparte tu comisión</h1>
    <p class="text-justify"><br />En este espacio podrás compartir las actividades, los conocimientos, las experiencias y las lecciones aprendidas  obtenidas en tus comisiones. </p>
    <p class="text-justify">Algunos de los documentos que podrás compartir son los pasabordos, certificados de permanencia, fotografías, presentaciones utilizadas, y demás documentos que consideres relevantes para dar a conocer las actividades, gestiones y compromisos adquiridos  durante la comisión.</p>
    <p class="text-justify">Para empezar, verifica que aparezca el lugar que visitaste, la fecha de inicio y de finalización de la comisión y el objeto.</p>
    <p class="text-justify">Recuerda que debes completar los datos de las comisiones que realices dentro de los siguientes tres días hábiles posteriores a la fecha de finalización de la comisión. Haz clic <a href="http://somos.dane.gov.co/comisiones/uploads/instructivo_comisiones_v2.pdf" target="_black">aquí</a> para ver el instructivo.</p>

    <?php //print_r($this->session->userdata); ?>
        <!--Tienes <?php echo count($listado); ?> Comisiones-->
    <h3>Comisiones pendientes</h3>
    <table class="table table-striped" id="TblComisionesPend">
        <thead>
        <th class="col-lg-2 text-center">Lugar</th>
        <th class="col-lg-1 text-center">Fecha de inicio</th>
        <th class="col-lg-1 text-center">Fecha de finalizaci&oacute;n</th>
        <th class="col-lg-6 text-center">Objeto de la comisi&oacute;n</th>
        <th class="col-lg-1 text-center">Informe</th>
        <th class="col-lg-1 text-center">No ejecutada</th>
    </thead>
    <tbody>
        <?php foreach ($listado as $valor) { ?>
            <?php if ($valor->id_datos == null) { ?>
                <tr>
                    <td>
                        <?php if ($valor->id_lugar != null) { ?>
                                <!--<a href="javascript:void(0);" data-toggle="modal" data-target="#mapa" onclick="carga_ajax('<?php echo base_url(); ?>index.php/comisiones/viewmapa','<?php echo $valor->id_lugar; ?>','Ver_mapa')"><i title="Ver ubicaci&oacute;n" class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>-->
                        <?php } else { ?> 
                                <!--<a href="#agregarmapa" id="AddMapa" data-idmapa = "<?php echo $valor->LUGAR_COMISION; ?>" data-toggle="modal" data-target="#agregarmapa" data-placement="top"><i title="Agregar ubicaci&oacute;n" class="fa fa-plus-square-o fa-2x" aria-hidden="true"></i></a>-->
                        <?php } ?>
                        <!--<a href="<?php echo base_url(); ?>index.php/comisiones/mapa/<?php echo $valor->LUGAR_COMISION . "/propias/" . $valor->id_lugar; ?>" ><i title="Ver ubicaci&oacute;n" class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>-->
                        <?php echo $valor->LUGAR_COMISION; ?><br />
                        <?php echo $valor->direccion; ?>
                    </td>
                    <td><?php echo $valor->FECHA_INICIAL; ?></td>
                    <td><?php echo $valor->FECHA_FINAL; ?></td>
                    <td><?php echo $valor->OBJETO; ?></td>
                    <td align="center">
                        <?php
                        $FechaActual = date('Y-m-d');
                        $Da = explode("-", $FechaActual);
                        $diaNac = $Da[2];
                        $mesNac = $Da[1];
                        $anoNac = $Da[0];

                        $FechaActual = mktime(0, 0, 0, "$mesNac", "$diaNac", "$anoNac");

                        $FechaProximo = $valor->FECHA_FINAL;
                        $Da1 = explode("-", $FechaProximo);
                        $diaNac1 = $Da1[2];
                        $mesNac1 = $Da1[1];
                        $anoNac1 = $Da1[0];

                        $FechaProximo = mktime(0, 0, 0, "$mesNac1", "$diaNac1", "$anoNac1");

                        $Diferencia = ($FechaActual - $FechaProximo);
                        $Dias = $Diferencia / (60 * 60 * 24);
                        //echo "Dias ".$Dias;
                        ?>
                        <?php if ($Dias > 4) { ?>
                            <a onclick="prueba();" href="<?php echo base_url(); ?>index.php/Comisiones/agregar/<?php echo $valor->INTERNO_GEN . "/" . $valor->INTERNO_ENC . "/" . $valor->VIGENCIA . "/" . $valor->CODIGO_UNIDAD_EJECUTORA . "/" . $valor->VB_OD; ?>" class="">
                                <img src="<?php echo base_url(); ?>public/images/triste.png" class="img-circle" title="Completa tu comis&oacute;n" height="50px" width="50px" /><br />
                                <i title="Completa tu comis&oacute;n" class="fa fa-plus-circle" aria-hidden="true">Adicionar</i>
                            </a>
                        <?php } else { ?>
                            <a href="<?php echo base_url(); ?>index.php/Comisiones/agregar/<?php echo $valor->INTERNO_GEN . "/" . $valor->INTERNO_ENC . "/" . $valor->VIGENCIA . "/" . $valor->CODIGO_UNIDAD_EJECUTORA . "/" . $valor->VB_OD; ?>" class=""><i title="Adicionar" class="fa fa-plus-circle fa-2x" aria-hidden="true"></i><br />Adicionar </a>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <a href="<?php echo base_url(); ?>index.php/Comisiones/noejecutada/<?php echo $valor->INTERNO_GEN . "/" . $valor->INTERNO_ENC . "/" . $valor->VIGENCIA . "/" . $valor->CODIGO_UNIDAD_EJECUTORA . "/" . $valor->VB_OD; ?>" class="text-center"><i title="Comisión no ejecutada" class="fa fa-trash-o fa-2x" aria-hidden="true"></i><br />No Ejecutada </a>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?> 
    </tbody>
    </table>
    <br /><br /><br />
    <h3>Comisiones completadas</h3>
    <table class="table table-striped" id="TblComisionesComple">
        <thead>
        <th class="td-ancho-16 text-center">Lugar</th>
        <th class="td-ancho-9 text-center">Fecha de inicio</th>
        <th class="td-ancho-9 text-center">Fecha de finalizaci&oacute;n</th>
        <th class="text-center">Objeto de la comisi&oacute;n</th>
        <th class="text-center">Estado</th>
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
                        <a href="<?php echo base_url(); ?>index.php/comisiones/mapa/<?php echo $valor->id_datos . "/" . $valor->LUGAR_COMISION . "/propias/" . $valor->id_lugar; ?>" ><i title="Ver ubicaci&oacute;n" class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>
                        <?php echo $valor->LUGAR_COMISION; ?><br />
                        <?php echo $valor->direccion; ?>
                    </td>
                    <td><?php echo $valor->FECHA_INICIAL; ?></td>
                    <td><?php echo $valor->FECHA_FINAL; ?></td>
                    <td><?php echo $valor->OBJETO; ?>
                        <br /><a href="javascript:void(0);" data-toggle="modal" data-target="#resumen" onclick="carga_ajax('<?php echo base_url(); ?>index.php/comisiones/resumen', '<?php echo $valor->id_datos; ?>', 'Ver_resumen')">Ver resumen <i title="Adicionar" class="fa fa-info-circle" aria-hidden="true"></i></a>    
                    </td>
                    <td><?php echo $valor->estado_comi; ?></td>
                    <td align="center">
                        <?php if ($valor->id_datos != null) {
                            if ($valor->ejecutada == 0) {
                                ?>
                                <img src="<?php echo base_url(); ?>public/images/feliz.png" class="img-circle" title="Completa tu comis&oacute;n" height="50px" width="50px" /><br/>
                                <a href="<?php echo base_url(); ?>index.php/Comisiones/ver/<?php echo $valor->id_datos; ?>" class=""><i title="Detalle" class="fa fa-file-text-o fa-2x" aria-hidden="true"></i> </a>
                                <a href="<?php echo base_url(); ?>index.php/Comisiones/editar/<?php echo $valor->id_datos . "/" . $valor->VB_OD; ?>" class=""><i title="Editar" class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
                            <?php } else { ?>
                                <a href="#" class=""><i title="No ejecutada" class="fa fa-ban fa-2x" aria-hidden="true"></i></a>
                            <?php } ?>    
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
                    <h4 class="modal-title" id="myModalLabel">Ubicaci&oacute;n</h4>
                </div>
                <div class="modal-body">
                    <div class="text-center" id="Ver_mapa">

                    </div><div id="map" style="width: 100%; height: 400px"></div>
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
