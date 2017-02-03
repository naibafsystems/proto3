<?php if ($this->session->userdata('logueado')) { ?>
    <h1>Gestionar</h1>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <br /><br /><br />
            <form id="carga_inicial" name="carga_inicial" >
                <input type="hidden" id="ruta" value="<?php echo base_url();?>index.php/palabras/analisis" />
                <input type="hidden" value="<?php echo $tipo_comi_sel; ?>" id="tipo_comision" />
                <input type="hidden" value="<?php echo $aspecto_sel; ?>" id="aspecto_sel" />
                <input type="hidden" value="<?php echo $criterio_sel; ?>" id="criterio_sel" />
                <input type="hidden" value="all" id="llave" />
                <input type="hidden" value="datos_tbl" id="salida" />
            </form>
            <table class="table table-striped" id="TblComisiones">
                <thead>
                    <th class="col-lg-3 text-center">Criterio</th>
                    <th class="col-lg-2 text-center">Aspecto</th>
                    <th class="col-lg-3 text-center">Descripción</th>
                    <th class="col-lg-2 text-center">Actividades / Comentarios</th>
                    <th class="col-lg-2 text-center">Fecha</th>
                </thead>
                <tbody>
                    <?php foreach ($listado as $valor){ ?>
                        <tr>
                            <td><?php echo $valor->id_criterio; ?></td>
                            <td><?php echo $valor->aspecto; ?></td>
                            <td><?php echo $valor->descripcion; ?></td>
                            <td>
                                <?php 
                                     echo $valor->actividades; 
                                ?>
                                
                            </td>
                            <td>
                                <?php 
                                
                                    echo $valor->fecha_actividad; 
                                ?>
                            </td>
                        </tr>
                    <?php } ?> 
                </tbody>
            </table>
        </div>
    </div>
<?php }else{ echo redirect(base_url("index.php/login/iniciar_sesion")); } ?>
