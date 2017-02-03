<?php if ($this->session->userdata('logueado')) { ?>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li class="active">Comisiones</li>
    </ol>
    <h1>Comparte tus comisiones para la gestión del conocimiento</h1><br />
    <?php if ($error == "exito") { ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Exito!</strong> se creo correctamente la comisi&oacute;n.
        </div>
    <?php } ?>
    <?php if ($error == "editar") { ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Exito al editar!</strong> se edito correctamente la comisi&oacute;n.
        </div>
    <?php } ?>
    <?php if ($error == "sobrepaso") { ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Alerta!</strong> No se edito la comisi&oacute;n ya se a editado las 3 veces permitidas .
        </div>
    <?php } ?>
    <form name="validacion" id="validacoion">
        <input type="hidden" name="autor" id="autor" value="<?php echo $datos_comisiones[0]->mail_usuario; ?>" />
        <input type="hidden" name="lector" id="lector" value="<?php echo $this->session->userdata('mail'); ?>" />
    </form>
    <div class="well">
        <p><b>Nombre: </b><?php echo ucwords(mb_strtolower($datos_comisiones[0]->NOMBRE)); ?> <!--<b>Número de documento: </b><?php //echo $datos_comisiones[0]->NUMERO_DOCUMENTO;      ?>--></p>
        <p><b>Objeto de la omisión: </b><?php echo $datos_comisiones[0]->OBJETO; ?></p>
        <p><b>Fecha de inicio: </b><?php echo $datos_comisiones[0]->FECHA_INICIAL; ?> <b>Fecha de finalización: </b><?php echo $datos_comisiones[0]->FECHA_TERMINACION; ?></p>
        <p><b>Lugar: </b><?php echo $datos_comisiones[0]->LUGAR_COMISION; ?></p>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalle comisión</h3>
                </div>
                <div class="panel-body">
                    <input type="hidden" id="tipo" value="<?php echo $datos_comisiones[0]->tipo_comi; ?>" />
                    <input type="hidden" id="tema" value="<?php echo $datos_comisiones[0]->id_tema; ?>" />
                    <p><b>Tipo: </b> <?php
                        switch ($datos_comisiones[0]->tipo_comi) {
                            case "N":
                                echo "Nacional";
                                break;
                            case "S":
                                echo "Internacional";
                                break;
                        }
                        //echo $datos_comisiones[0]->tipo_comi; 
                        ?></p>
                    <p><b>Tema: </b> <?php
                        switch ($datos_comisiones[0]->id_tema) {
                            case "1":
                                echo "Reuniones";
                                break;

                            case "2":
                                echo "Capacitaciones";
                                break;

                            case "3":
                                echo "Eventos";
                                break;

                            case "4":
                                echo "Observación del aprendizaje";
                                break;

                            case "5":
                                echo "Visitas técnicas";
                                break;

                            case "6":
                                echo "Servicios";
                                break;

                            case "7":
                                echo "Estudios";
                                break;
                        }

                        //echo $datos_comisiones[0]->id_tema; 
                        ?></p>
                    <p><b>Resumen comisión: </b> <?php echo $datos_comisiones[0]->resumen_comision; ?></p>
                    <!--<p><b>Participantes: </b> <?php echo $datos_comisiones[0]->participantes; ?></p>-->
                    <p><b>Datos de contacto: </b></p>
                    <table class="table table-striped table-bordered" id="TblArchivos">
                        <thead>
                        <th class="text-center col-lg-2">Nombre</th>
                        <th class="text-center col-lg-2">Apellido</th>
                        <th class="text-center col-lg-2">Cargo</th>
                        <th class="text-center col-lg-2">Correo electrónico</th>
                        <th class="text-center col-lg-2">Telefono</th>
                        </thead>
                        <tbody>
                            <?php if ($contactos == null) { ?>
                                <tr>
                                    <td class="text-center" colspan="5">No se encontrar&oacute;n documentos anexos</td>
                                </tr>
                            <?php } ?>
                            <?php foreach ($contactos as $valor) { ?>
                                <tr>
                                    <td><?php echo $valor->nombre; ?></td>
                                    <td><?php echo $valor->apellido; ?></td>
                                    <td><?php echo $valor->cargo; ?></td>
                                    <td><?php echo $valor->mail; ?></td>
                                    <td><?php echo $valor->telefono; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <hr />
                    <table class="table table-bordered table-hover" id="TblAprendizaje">
                        <thead>
                        <th class="text-center col-sm-3">Criterios</th>
                        <th class="text-center col-sm-3">Fortalezas y aspectos positivos</th>
                        <th class="text-center col-sm-3">Oportunidades de mejora</th>
                        <th class="text-center col-sm-3">Aplicaciones para la entidad</th>
                        </thead>
                        <tbody>
                            <?php foreach ($aspectos as $Aspecto) { ?>
                                <tr>
                                    <td><b><?php echo $Aspecto->criterio ?></b></td>
                                    <td><?php echo $Aspecto->fortalezas_ap ?></td>
                                    <td><?php echo $Aspecto->oportunidades_ap ?></td>
                                    <td><?php echo $Aspecto->aplicaciones_ap ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <table class="table table-hover table-bordered" id="TblNacional">
                        <thead>
                        <th class="col-lg-4">Actividades desarrolladas</th>
                        <th class="col-sm-4">Fortalezas y aspectos positivos</th>
                        <th class="col-sm-4">Oportunidades de mejora</th>
                        </thead>
                        <tbody>
                            <?php foreach ($aspectos as $Aspecto) { ?>
                                <tr>
                                    <td><?php echo $Aspecto->actividades_desarrolladas_ot ?></td>
                                    <td><?php echo $Aspecto->fortalezas_asp_positivos_ot ?></td>
                                    <td><?php echo $Aspecto->oportunidades_mejora_ot ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <table class="table table-hover" id="TblInternacional">
                        <thead>
                        <th class="col-lg-4">Temas tratados</th>
                        <th class="col-sm-4">Fortalezas y aspectos positivos</th>
                        <th class="col-sm-4">Oportunidades de mejora</th>
                        </thead>
                        <tbody>
                            <?php foreach ($aspectos as $Aspecto) { ?>
                                <tr>
                                    <td><?php echo $Aspecto->actividades_desarrolladas_ot ?></td>
                                    <td><?php echo $Aspecto->fortalezas_asp_positivos_ot ?></td>
                                    <td><?php echo $Aspecto->oportunidades_mejora_ot ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                        <!--<p id="aplicaciones"><b>Recomendaciones o sugerencias: </b> <?php echo $datos_comisiones[0]->conclusiones; ?></p>-->
                    <p><b>Recomendaciones o sugerencias: </b> <?php echo $datos_comisiones[0]->recomendaciones; ?></p>

                    <h3>Documentos anexos</h3>
                    <table class="table table-striped table-bordered" id="TblArchivos">
                        <thead>
                        <th class="text-center col-lg-4">Nombre archivo</th>
                        <th class="text-center col-lg-6">Resumen</th>
                        <th class="text-center col-lg-2">Descargar</th>
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
                                    <td class="text-center"><a href="<?php echo $valor->archivo_ruta . "/" . $valor->archivo; ?>" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if ($datos_comisiones[0]->com_administradores_id == $this->session->userdata('id_user')) { ?>
                        <br />
                        <h3>Documentos legalización</h3>
                        <table class="table table-striped table-bordered">
                            <thead>
                            <th class="text-center col-lg-4">Nombre archivo</th>
                            <th class="text-center col-lg-2">Descargar</th>
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
                                        <td class="text-center"><a href="<?php echo $valor->archivo_ruta . "/" . $valor->archivo; ?>" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                    <?php if ($imagenes != null) { ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
                            <p>&nbsp;</p>
                            <div id="carousel-example-captions" class="carousel slide" data-ride="carousel"> 
                                <ol class="carousel-indicators">
                                    <?php
                                    $nums_slides = count($imagenes);
                                    $active = "active";
                                    for ($i = 0; $i < $nums_slides; $i++) {
                                        ?>
                                        <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i; ?>" class="<?php echo $active; ?>"></li>
                                        <?php
                                        $active = "";
                                    }
                                    ?>
                                </ol>
                                <div class="carousel-inner" role="listbox"> 
                                    <?php
                                    $active = "active";
                                    foreach ($imagenes as $val) {
                                        ?>
                                        <div class="item <?php echo $active; ?> "> 
                                            <img data-src="holder.js/900x500/auto/#777:#777" alt="900x500" src="<?php echo $val->archivo_ruta . "/" . $val->archivo; ?>" data-holder-rendered="true"> 
                                            <div class="carousel-caption"> 
                                                <h3><?php echo $val->archivo; ?></h3>
                                                <p><?php echo $val->resumen_archivo; ?></p> 
                                                <!--<a class='btn btn-primary text-right' href="#">aaaa </a>-->
                                            </div> 
                                        </div>
                                        <?php
                                        $active = "";
                                    }
                                    ?>	
                                </div> 
                                <a class="left carousel-control" href="#carousel-example-captions" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> 
                                <a class="right carousel-control" href="#carousel-example-captions" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> 
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="votacion">
            <div class="text-right"> Esta comisi&oacute;n ha sido vista <?php echo $visitas; ?> veces.</div>
            <div class="text-right"> Cuéntanos qué tan útil es este informe para ti.</div>
            <?php
            $num_ratings = $votos_count[0]->num;

            //echo "Numero de votos: ".$num_ratings;
            //Si los votos son positivos
            if ($votos[0]->sum > 0) {
                //Guardamos la suma
                $sum_ratings = $votos[0]->sum;
            } else {
                //La suma vale 0
                $sum_ratings = 0;
            }
            //echo "<br>suma de votos: ".$sum_ratings;
            $rating = 0;

            if ($num_ratings == null) {
                $num_ratings = 0;
            }
            //Si la suma de votos es mayor que 0
            if ($num_ratings > 0) {
                //Calculamos el número de estrellas a pintar
                $rating = round($sum_ratings / $num_ratings);
            }

            //echo "<br> el rating es: ".$rating;
            ?>
            <div class="rating" id="rating<?php echo $datos_comisiones[0]->id_datos; ?>" data="<?php echo $datos_comisiones[0]->id_datos; ?>">
                <?php
                //Por cada estrella
                for ($i = 1; $i <= 5; $i++) {
                    switch ($i) {
                        case 1:
                            $titulo = "No fue &uacute;til";
                            break;
                        case 2:
                            $titulo = "Poco útil";
                            break;
                        case 3:
                            $titulo = "Útil";
                            break;
                        case 4:
                            $titulo = "Muy útil";
                            break;
                        case 5:
                            $titulo = "Fue bastante útil";
                            break;
                    }
                    //Si toca pintarla de verde
                    if ($i <= $rating) {
                        //Mostramos estrella verde
                        echo '<div title="' . $titulo . '" data-toggle="tooltip" data-placement="top" class="estrella selected" id="rating' . $datos_comisiones[0]->id_datos . '_' . $i . '" data=' . $i . ' data-url=' . base_url() . ' >&nbsp;</div>';
                    } else {
                        //Mostramos estrella gris
                        echo '<div title="' . $titulo . '" data-toggle="tooltip" data-placement="top" class="estrella" id="rating' . $datos_comisiones[0]->id_datos . '_' . $i . '" data=' . $i . ' data-url=' . base_url() . ' >&nbsp;</div>';
                    }
                }
                ?>
                <div id="sumrating" data="<?php echo $sum_ratings ?>" style="display:none">&nbsp;</div>
                <div id="numrating" data="<?php echo $num_ratings ?>" style="display:none">&nbsp;</div>
                <div  id="actual" data="<?php echo $rating ?>" ><?php echo $num_ratings; ?> Votos, Promedio <?php echo $rating; ?>&nbsp;</div>
                <div class="ok" style="display:none;">&nbsp;</div>
            </div>
        </div>
    </div>
    <br /><br /><br />
    <div class="row">
        <h3>Comentarios</h3><a href="#comentario"> Agregar comentario</a>
        <br /><br />
        <?php foreach ($comentarios as $valor) { ?>
            <blockquote>
                <p><b><?php echo $valor->asunto; ?></b></p>
                <p><?php echo $valor->comentario; ?></p>
                <cite>Usuario: <?php echo $valor->usuario; ?> Fecha: <?php echo $valor->fecha_comentario; ?></cite> <!--</a><cite title="Source Title">Comentario</cite>-->
            </blockquote>
        <?php } ?>
        <br /><br />
        <div id="comentario">
            <h3>Agregar comentario</h3>
            <form class="form-signin" method="post" action="<?php echo site_url("comisiones/agregarcomentario"); ?>">
                <input type="hidden" id="id_datos" name="id_datos" value="<?php echo $datos_comisiones[0]->id_datos; ?>"/>	
                <div class="form-group" >
                    <label for="asunto" >Asunto</label>
                    <input type="text" id="asunto" name="asunto" class="form-control" placeholder="Asunto" required="" />
                </div>
                <div class="form-group" >
                    <label for="comentario" >Comentario</label>
                    <textarea id="comentario" name="comentario" class="form-control" placeholder="Comentario" required=""></textarea>
                </div>
                <button type="submit" id="btnIngresar" name="btnIngresar" class="btn btn-primary ">Agregar comentario</button>
            </form>
        </div>  
    </div>
    <?php
} else {
    echo redirect(base_url("index.php/login/iniciar_sesion"));
}
?>