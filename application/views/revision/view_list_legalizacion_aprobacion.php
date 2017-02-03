<?php 
if ($this->session->userdata('logueado'))
{ 
?>
	
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li class="active">Legalizaci&oacute;n aprobaci&oacute;n</li>
    </ol>
    <h1>Aprobaci&oacute;n de legalizaciones</h1> 
    <p class="text-justify"><br/>En el siguiente listado apareceran las comisiones que estan en proceso de aprobaci&oacute;n para su respectivo proceso</p>

	<?php
	$retornoExito = $this->session->flashdata('retornoExito');
	if ($retornoExito) {
		?>
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<?php echo $retornoExito ?>
		</div>
		<?php 
	}

	$retornoError = $this->session->flashdata('retornoError');
	if ($retornoError) {
		?>
		<div class="alert alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<?php echo $retornoError ?>
		</div>
		<?php
	}
		?>
		<div>

		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#plegalizar" aria-controls="plegalizar" role="tab" data-toggle="tab">Comisiones legalizadas</a></li>
			<!--<li role="presentation"><a href="#legalizadas" aria-controls="legalizadas" role="tab" data-toggle="tab">Comisiones legalizadas</a></li>
			<li role="presentation"><a href="#devueltas" aria-controls="devueltas" role="tab" data-toggle="tab">Comisiones devueltas</a></li>-->
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
			<!--PANEL POR LEGALIZAR-->
			<div role="tabpanel" class="tab-pane active" id="plegalizar">
				<?php
					$id = 0;
					$listado = $this->M_revision->comisiones_legalizadas();
					
					if(count($listado)>0){
						foreach ($listado as $valor) {						
							$interno_gen = $valor->interno_gen;
							$interno_enc = $valor->interno_enc;
							$vigencia = $valor->vigencia;
							$cod_unidad = $valor->codigo_unidad_ejecutora;

							$listado_com_todos = $this->M_comisiones->get_todos_com($interno_gen, $interno_enc, $vigencia, $cod_unidad);
							
							if(count($listado_com_todos)>0){

								$listado_com = $this->M_comisiones->get_comision_id(0, $interno_gen, $interno_enc, $vigencia, $cod_unidad);
								
								$estado = $this->M_revision->estado_comision($listado_com_todos[0]->id_datos); 
								
								$archivos = $this->M_revision->archivos_comision($listado_com_todos[0]->id_datos); 
								$ar_rutas = $this->M_revision->archivos_comision_rutas($listado_com_todos[0]->id_datos);

								$NOMBRE = $listado_com[0]->NOMBRE;
								$NUM_IDENT = $listado_com[0]->NUMERO_DOCUMENTO;
								$OBJETO = $listado_com[0]->OBJETO;
								$FECHA_INICIAL = $listado_com[0]->FECHA_INICIAL;
								$FECHA_FINAL = $listado_com[0]->FECHA_FINAL;
								$LUGAR_COMISION = $listado_com[0]->LUGAR_COMISION;

								if($id % 2 == 0){
									$class = "style='background-color:#E9E9E9'";
								}else{
									$class = "style='background-color:#FFFFFF'";
								}
								$listadoEstados = $this->M_revision->estados_comision($listado_com_todos[0]->id_datos);
								?>
								<div class="row" <?php echo  $class?>>
									<form class="form-horizontal formRevision" enctype="multipart/form-data" action="<?php echo base_url('index.php/revision/guardarAprobacion');?>" method="post" id="formReg<?php echo  $id?>" name="formReg<?php echo  $id?>">
									<input type="hidden" name="id_datos" id="id_datos" value="<?php echo  $listado_com_todos[0]->id_datos?>">
									<div class="row">
										<div class="col-md-8">
											<div class="row">
												<div class="col-md-10 col-md-offset-1">											
													<div class="col-md-8">  
														<p><b>Fecha legalizaci&oacute;n: <?php echo $valor->fecha_legalizacion?></b></p>
													</div>
													<div class="col-md-4">
													<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal-<?php echo $id ?>">Estados <span class="badge"><?php echo count($listadoEstados)?></span></button>
													<!-- Modal -->
													<div class="modal fade" id="myModal-<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
													  <div class="modal-dialog">
														<div class="modal-content"> 
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title" id="myModalLabel">Estados Comisi&oacute;n</h4>
														  </div>
														  <div class="modal-body">
															<table class="table">
																<thead>
																	<tr>
																		<th>Fecha</th>
																		<th>Usuario</th>
																		<th>Observaciones</th>
																	</tr>
																</thead>
																<tbody>
																<?php
																for($es=0;$es<count($listadoEstados);$es++){
																	$datos_user = $this->M_revision->datos_usuario_crm($listadoEstados[$es]->usuario);
																	?>
																	<tr>
																		<td><?php echo $listadoEstados[$es]->fecha_actualizacion?></td>
																		<?php
																		if(count($datos_user)>0){
																		?>
																			<td><?php echo $datos_user[0]->NOM_USUARIO." ".$datos_user[0]->APE_USUARIO?></td>
																		<?php
																		}else{
																			?>
																			<td><?php echo $listadoEstados[$es]->usuario?></td>
																			<?php
																		}	
																		
																		?>
																		
																		<td><?php echo $listadoEstados[$es]->observaciones?></td>
																	</tr>
																	<?php
																}
																?>
																</tbody>
															</table>															
														  </div>
														  <div class="modal-footer">
															<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
														  </div>
														</div>
													  </div>
													</div>
												</div>
													<div class="col-md-12">
														<p><b>Tipo de Cuenta: <?php if($valor->tipo_cuenta == 'AV'){echo "Legalizaci&oacute;n de avance";}else{ echo "Legalizaci&oacute;n y pago de cuenta";}?></b></p>
													</div>
													<div class="col-md-8">  
														<p class="text-justify"><b>Nombre: </b><?php echo $NOMBRE?></p>
													</div>
													<div class="col-md-4">
														<p  class="text-justify"><b>Cedula:</b><?php echo $NUM_IDENT?></p>
													</div>
													<div class="col-md-12">
														<p><b>Objeto de la comisi&oacute;n: </b><?php echo $OBJETO?></p>
													</div>
													<div class="col-md-8">  
														<p><b>Fecha de inicio: </b><?php echo $FECHA_INICIAL?></p>
													</div>
													<div class="col-md-4">
														<p><b>Fecha fin: </b><?php echo $FECHA_FINAL?></p>
													</div>
													<div class="col-md-12">
														<p><b>Lugar: </b><?php echo $LUGAR_COMISION?></p> 
													</div>
												</div>
											</div>	
											<div class="row">										
												<div class="col-md-10 col-md-offset-1"> 
													<div class="col-md-12">
														<div class="input-group">
															<span class="input-group-addon" id="basic-addon1">
															  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Estado
															</span>
															<select class="form-control  validate[required]" id="estado<?php echo  $id?>" name="estado">
																<option value="">Seleccione...</option>																
																<option value="5">Aprobada</option>
																<option value="2">Revisi&oacute;n</option>
															</select>
														</div>
														<p>
															<textarea rows="3" name="observaciones" id="observaciones" placeholder="Observaciones" class="form-control validate[required]"></textarea>
														</p>
														<p><button type="submit" class="btn btn-lg btn-success btn-block" value="<?php echo  $id?>">Guardar</button></p>
													</div>
												</div>
											</div>										
										</div>
										<div class="col-md-4">
											<div class="row">
												<div class="col-md-8 col-md-offset-2">
													<ul class="list-group">
														<?php
														if($valor->doc_reintegro != ''){
															?>
																<li class="list-group-item"><a href="<?php echo base_url('uploads/legalizacion/'.$valor->doc_reintegro)?>" target="_blank"> Reintegro</a></li>
															<?php
														}
														
														if($valor->doc_cdp != ''){
															?>
																<li class="list-group-item"><a href="<?php echo base_url('uploads/legalizacion/'.$valor->doc_cdp)?>" target="_blank"> CDP</a></li>
															<?php
														}
														
														if($valor->doc_re != ''){
															?>
																<li class="list-group-item"><a href="<?php echo base_url('uploads/legalizacion/'.$valor->doc_re)?>" target="_blank"> Resoluci&oacute;n</a></li>
															<?php
														}
														
														if($valor->doc_rp != ''){
															?>
																<li class="list-group-item"><a href="<?php echo base_url('uploads/legalizacion/'.$valor->doc_rp)?>" target="_blank"> RP</a></li>
															<?php
														}
														
														if($valor->doc_fl != ''){
															?>
																<li class="list-group-item"><a href="<?php echo base_url('uploads/legalizacion/'.$valor->doc_fl)?>" target="_blank"> Formato legalizaci&oacute;n</a></li>
															<?php
														}
														?>
														<li class="list-group-item"><a href="<?php echo base_url('index.php/revision/generaWord/'.$listado_com_todos[0]->id_datos)?>"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Informe</a></li>
														<?php
														if(count($archivos) > 0){													
															for($an = 0;$an<count($archivos);$an++){
																?>
																	<li class="list-group-item"><a href="<?php echo $archivos[$an]->archivo_ruta."/".$archivos[$an]->archivo?>" target="_blank"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span> <?php echo $archivos[$an]->archivo?></a></li>
																<?php
															}
														}
														
														if(count($ar_rutas) > 0){  													
															for($ar = 0;$ar<count($ar_rutas);$ar++){
																?>
																<li class="list-group-item"><a href="<?php echo $ar_rutas[$ar]->archivo_ruta."/".$ar_rutas[$ar]->archivo?>" target="_blank"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> <?php echo $ar_rutas[$ar]->archivo?></a></li>
																<?php
															}
														}
														?>
													  
													</ul>
												</div>
											</div>										
										</div>
									</div>
									</form>
								</div>
								
								<?php
								$id++;	
							}			
						}
					}else{
						?>
						<h1>No tiene comisiones pendientes de aprobaci&oacute;n</h1>
						<?php
					}
					
				
				
				?>
			</div>
			<!--PANEL LEGALIZADAS-->
			<div role="tabpanel" class="tab-pane" id="legalizadas">
			
			<?php
				$id = 0;
				for($i=0;$i<count($user_dep);$i++){
					$listado = $this->M_comisiones->get_todos_ident($user_dep[$i]->NUM_IDENT);

					foreach ($listado as $valor) {						
						$interno_gen = $valor->INTERNO_GEN;
						$interno_enc = $valor->INTERNO_ENC;
						$vigencia = $valor->VIGENCIA;
						$cod_unidad = $valor->CODIGO_UNIDAD_EJECUTORA;

						$listado_com_todos = $this->M_comisiones->get_todos_com($interno_gen, $interno_enc, $vigencia, $cod_unidad);
						
						if(count($listado_com_todos)>0){

							$listado_com = $this->M_comisiones->get_comision_id(0, $interno_gen, $interno_enc, $vigencia, $cod_unidad);

							$estado = $this->M_revision->estado_comision($listado_com_todos[0]->id_datos); 

							$NOMBRE = $listado_com[0]->NOMBRE;
							$OBJETO = $listado_com[0]->OBJETO;
							$FECHA_INICIAL = $listado_com[0]->FECHA_INICIAL;
							$FECHA_FINAL = $listado_com[0]->FECHA_FINAL;
							$LUGAR_COMISION = $listado_com[0]->LUGAR_COMISION;

							if($id % 2 == 0){
								$class = "style='background-color:#F1F1F1'";
							}else{
								$class = "style='background-color:#FFFFFF'";
							}
							
							if(isset($estado[0]) && $estado[0]->id_estado == 2){
							?>
							<div class="row" <?php echo  $class?>>
								<form class="form-horizontal formRevision" enctype="multipart/form-data" action="<?php echo base_url('index.php/revision/guardarEstado');?>" method="post" id="formReg<?php echo  $id?>" name="formReg<?php echo  $id?>">
								<div class="row">
									<div class="col-md-8">
										<div class="col-md-10 col-md-offset-1">
											<p><b>Nombre: </b><?php echo $user_dep[$i]->NOM_USUARIO." ".$user_dep[$i]->APE_USUARIO?>         <b>Cedula:</b><?php echo $user_dep[$i]->NUM_IDENT?></p>
											<p><b>Objeto de la comisi&oacute;n: </b><?php echo $OBJETO?></p>
											<p><b>Fecha de inicio: </b><?php echo $FECHA_INICIAL?> - <b>Fecha fin: </b><?php echo $FECHA_FINAL?></p>
											<p><b>Lugar: </b><?php echo $LUGAR_COMISION?>     <b>Ruta: </b><?php echo $LUGAR_COMISION?></p>
										</div>									
									</div>
									<div class="col-md-4">
										<div class="col-md-8 col-md-offset-2">
											<p><a href="" target="_blank">Informe</a></p>						
											<p><span class="label label-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>Aprobado</span></p>
										</div>
									</div>
								</div>						
								</form>
							</div>
							
							<?php
							$id++;	
							}		
						}			
					}
				}
				
				
				?>
			</div>
			<!--PANEL  DEVUELTAS-->
			<div role="tabpanel" class="tab-pane" id="devueltas">
			
			<?php
				$id = 0;
				for($i=0;$i<count($user_dep);$i++){
					$listado = $this->M_comisiones->get_todos_ident($user_dep[$i]->NUM_IDENT);

					foreach ($listado as $valor) {						
						$interno_gen = $valor->INTERNO_GEN;
						$interno_enc = $valor->INTERNO_ENC;
						$vigencia = $valor->VIGENCIA;
						$cod_unidad = $valor->CODIGO_UNIDAD_EJECUTORA;

						$listado_com_todos = $this->M_comisiones->get_todos_com($interno_gen, $interno_enc, $vigencia, $cod_unidad);
						
						if(count($listado_com_todos)>0){

							$listado_com = $this->M_comisiones->get_comision_id(0, $interno_gen, $interno_enc, $vigencia, $cod_unidad);

							$estado = $this->M_revision->estado_comision($listado_com_todos[0]->id_datos); 

							$NOMBRE = $listado_com[0]->NOMBRE;
							$OBJETO = $listado_com[0]->OBJETO;
							$FECHA_INICIAL = $listado_com[0]->FECHA_INICIAL;
							$FECHA_FINAL = $listado_com[0]->FECHA_FINAL;
							$LUGAR_COMISION = $listado_com[0]->LUGAR_COMISION;

							if($id % 2 == 0){
								$class = "style='background-color:#F1F1F1'";  
							}else{
								$class = "style='background-color:#FFFFFF'";  
							}
							    
							if(isset($estado[0]) && $estado[0]->id_estado == 3){
							?>
							<div class="row" <?php echo  $class?>>
								<form class="form-horizontal formRevision" enctype="multipart/form-data" action="<?php echo base_url('index.php/revision/guardarEstado');?>" method="post" id="formReg<?php echo  $id?>" name="formReg<?php echo  $id?>">
								<div class="row">
									<div class="col-md-8">
										<div class="col-md-10 col-md-offset-1">
											<p><b>Nombre: </b><?php echo $user_dep[$i]->NOM_USUARIO." ".$user_dep[$i]->APE_USUARIO?>         <b>Cedula:</b><?php echo $user_dep[$i]->NUM_IDENT?></p>
											<p><b>Objeto de la comisi&oacute;n: </b><?php echo $OBJETO?></p>
											<p><b>Fecha de inicio: </b><?php echo $FECHA_INICIAL?> - <b>Fecha fin: </b><?php echo $FECHA_FINAL?></p>
											<p><b>Lugar: </b><?php echo $LUGAR_COMISION?></p>
										</div>									
									</div>
									<div class="col-md-4">
										<div class="col-md-8 col-md-offset-2">
											<p><a href="" target="_blank">Informe</a></p>						
											<p><span class="label label-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Devuelto</span></p>
										</div>
									</div>
								</div>						
								</form>
							</div>
							
							<?php
							$id++;	
							}		
						}			
					}
				}
				
				
				?>
			</div>
		  </div>

		</div>
		<?php
	
	
}else {
    echo redirect(base_url("index.php/login/iniciar_sesion"));
} ?>
