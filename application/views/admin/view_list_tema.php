<?php if ($this->session->userdata['admin']) { ?>
    <h1>Listado de temas</h1>
    <br /><br />
    <table class="table table-hover" id="tbltema">
        <thead>
        <th class="text-center">Tema</th>
        <th class="text-center">Descripción</th>
        <th class="text-center">Tipo Tema</th>
        <th class="text-center">Acción</th>
    </thead>
    <tbody>
        <?php foreach ($listado as $valor) { ?>
            <tr>
                <td><?php echo $valor->tema; ?></td>
                <td><?php echo $valor->detalle_tema; ?>
                <td><?php
                    if ($valor->tipo_tema == 0) {
                        echo "Normal";
                    } else {
                        echo "Observación y Aprendizaje";
                    }
                    ?>
                <td class="text-center">
                    <a href="#editartema" id="EditTema" data-toggle="modal" data-target="#editartema" data-placement="top" data-idtema = "<?php echo $valor->id_tema; ?>" data-tema = "<?php echo $valor->tema; ?>" data-detalle = "<?php echo $valor->detalle_tema; ?>" data-tipo = "<?php echo $valor->tipo_tema; ?>" class=""><i title="Editar el Tema" class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i> </a>
                    <a href="#borrartema" id="DeleteTema" data-toggle="modal" data-target="#borrartema" data-placement="top" data-idtema = "<?php echo $valor->id_tema; ?>" data-tema = "<?php echo $valor->tema; ?>" data-detalle = "<?php echo $valor->detalle_tema; ?>" data-tipo = "<?php echo $valor->tipo_tema; ?>" class=""><i title="Borrar el Tema" class="fa fa-trash-o fa-2x" aria-hidden="true"></i> </a>
                </td>
            </tr>
        <?php } ?> 
    </tbody>
    </table>
    <br />
    <a href="#agregartema" id="AddTema" data-toggle="modal" data-target="#agregartema" data-placement="top" class="btn btn-primary"><i title="Borrar el Tema" class="fa fa-plus-square-o " aria-hidden="true"></i> Nuevo Tema</a>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="agregartema">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Agregar Tema</h4>
                </div>
                <form class="form-signin" method="post" action="<?php echo site_url("tema/agregar"); ?>">
                    <div class="modal-body">		
                        <div class="form-group" >
                            <label for="tema" >Nombre Tema</label>
                            <input type="text" id="tema" name="tema" class="form-control" placeholder="Nombre del Tema" required="" autofocus />
                        </div>
                        <div class="form-group" >
                            <label for="detalle_tema" >Detalle Tema</label>
                            <input type="text" id="detalle_tema" name="detalle_tema" class="form-control" placeholder="Detalle Tema" required="" />
                        </div>
                        <div class="form-group" >
                            <label for="tipo" >Tipo Tema</label>
                            <select id="tipo_tema" name="tipo_tema" class="form-control">
                                <option value="0">Normal</option>
                                <option value="1">Observación y Aprendizaje</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn_enviar" name="btn_enviar" class="btn btn-primary ">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="editartema">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar Tema</h4>
                </div>
                <form class="form-signin" method="post" action="<?php echo site_url("tema/editar"); ?>">
                    <input type="hidden" id="idtema" name="idtema" />
                    <div class="modal-body">		
                        <div class="form-group" >
                            <label for="tema" >Nombre Tema</label>
                            <input type="text" id="temae" name="temae" class="form-control" placeholder="Nombre del Tema" required="" autofocus />
                        </div>
                        <div class="form-group" >
                            <label for="detalle_tema" >Detalle Tema</label>
                            <input type="text" id="detalle_temae" name="detalle_temae" class="form-control" placeholder="Detalle Tema" required="" />
                        </div>
                        <div class="form-group" >
                            <label for="tipo" >Tipo Tema</label>
                            <select id="tipo_temae" name="tipo_temae" class="form-control">
                                <option value="0">Normal</option>
                                <option value="1">Observación y Aprendizaje</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn_enviar" name="btn_enviar" class="btn btn-primary ">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="borrartema">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Borrar Tema</h4>
                </div>
                <form class="form-signin" method="post" action="<?php echo site_url("tema/eliminar"); ?>">
                    <input type="hidden" id="idtemab" name="idtemab" />
                    <div class="modal-body">		
                        <b>Desea continuar con la eliminacion del siguiente tema?</b><br /><br />
                        <div class="form-group" >
                            <label for="temab" >Nombre Tema</label>
                            <div id="temab"></div>
                        </div>
                        <div class="form-group" >
                            <label for="detalleb" >Detalle Tema</label>
                            <div id="detalleb"></div>
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
<?php } else { ?>
    <br />
    <div class="alert alert-danger"> 
        <strong>¡Error!</strong> No se encuentra autorizado para ingresar a esta parte del modulo.
    </div>
<?php } ?>                