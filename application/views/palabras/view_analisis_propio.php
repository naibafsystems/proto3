<?php if ($this->session->userdata('logueado')) { ?>
    <h1>Gestionar tu conocimiento</h1>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <br /><br /><br />
            <form action="<?php echo base_url();?>index.php/palabras/gestiouser" method="post" accept-charset="utf-8" class="form-horizontal" autocomplete="on">
                <input type="hidden" id="ruta" value="<?php echo base_url();?>index.php/palabras/gestionuser" />
                <input type="hidden" id="ruta_exito" value="<?php echo base_url();?>index.php/palabras/propias" />
                <input type="hidden" value="<?php echo $tipo_comi_sel; ?>" id="tipo_comision" />
                <input type="hidden" value="<?php echo $aspecto_sel; ?>" id="aspecto_sel" />
                <input type="hidden" value="<?php echo $criterio_sel; ?>" id="criterio_sel" />
                <input type="hidden" value="all" id="llave" />
                <input type="hidden" value="datos_tbl" id="salida" />
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
                                    if ($valor->aspecto == "Aspectos positivos"){ ?>
                                        
                                    <?php
                                    }elseif ($valor->actividades == null){ ?>
                                        <input required="" type="text" class="form-control" name="actividad<?php echo $valor->id_analisis;  ?>" id="actividad<?php echo $valor->id_analisis;  ?>" />
                                    <?php
                                    }else{
                                        echo $valor->actividades; 
                                    }?>

                                </td>
                                <td>
                                    <?php 
                                    if ($valor->aspecto == "Aspectos positivos"){ ?>
                                        
                                    <?php
                                    }elseif ($valor->fecha_actividad == null){ ?>
                                        <input required="" type="text" class="form-control" name="fecha<?php echo $valor->id_analisis;  ?>" id="fecha<?php echo $valor->id_analisis;  ?>" />
                                        <button type="button" name="guardar_actividad" id="guardar_actividad" value="<?php echo $valor->id_analisis;  ?> " class="btn btn-primary" onclick="clickbutton(this.value); ">Guardar</button>
                                    <?php
                                    }else{
                                        echo $valor->fecha_actividad; 
                                    }?>
                                </td>
                            </tr>
                        <?php } ?> 
                    </tbody>
                </table>
            </form>
        </div>
    </div>
<?php }else{ echo redirect(base_url("index.php/login/iniciar_sesion")); } ?>
