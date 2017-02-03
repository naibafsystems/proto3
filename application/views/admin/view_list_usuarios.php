<?php if (($this->session->userdata('logueado')) && $this->session->userdata['admin']) { ?>
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li class="active">Comisiones no ejecutadas</li>
    </ol>
    <div id="respuesta"></div>
    <h1>Usuarios en el sistema</h1>
    <br /><br /><br /><br />
    <table class="table table-striped" id="TblComisiones">
        <thead>
            <th class="col-lg-3">Usuario</th>
            <th class="col-lg-3">Dependencia</th>
            <th class="col-lg-3">Despacho</th>
            <th class="col-lg-3">Grupo</th>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario) { ?>
                <tr>
                    <td><?php echo $usuario->nombrefull; ?></td>
                    <td><?php echo $usuario->Dependencia; ?></td>
                    <td><?php echo $usuario->Despacho; ?></td>
                    <td><?php echo $usuario->Grupo; ?></td>
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
