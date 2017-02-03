<?php if (($this->session->userdata('logueado')) && $this->session->userdata['admin']) { ?>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li class="active">Comisiones no ejecutadas</li>
    </ol>
    <div id="respuesta"></div>
    <h1>Comisiones no ejecutadas</h1>
    <div>	
        <p><br />Aqui se podra activar de nuevo las comisiones marcadas como no ejecutadas.<br /></p>
    </div>
    <br /><br /><br /><br />
    <table class="table table-striped" id="TblComisiones">
        <thead>
            <th class="col-lg-1">Id</th>
            <th class="col-lg-4">Usuario</th>
            <th class="col-lg-4">Ejecutada</th>
            <th class="col-lg-1">Acción</th>
        </thead>
        <tbody>
            <?php foreach ($listado as $Comision) { ?>
                <tr>
                    <td><?php echo $Comision->id_datos; ?></td>
                    <td><?php echo $Comision->usuario; ?></td>
                    <td><?php echo $Comision->ejecutada; ?></td>
                    <td><a href="<?php echo base_url(); ?>index.php/Admin/update_ejecutadas/<?php echo $Comision->id_datos; ?>" ">Activar <i title="Activar comisión" class="fa fa-check" aria-hidden="true"></i></a></td>
                </tr>
            <?php } ?> 
        </tbody>
    </table>
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
<?php } else {
    echo redirect(base_url("index.php/login/iniciar_sesion"));
} ?>
