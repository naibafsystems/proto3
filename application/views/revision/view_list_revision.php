<?php if ($this->session->userdata('logueado')) { ?>
	
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li class="active">Revisi&oacute;n Comisiones</li>
    </ol>
    <h1>Revisi&oacute;n de comisiones</h1>
    <p class="text-justify"><br/>En el siguiente listado apareceran las comisiones que estan para revisi&oacute;n, aprobadas y para ajustes</p>  

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

	if(count($dependencia_jefe)>0){
		/*)
		if($dependencia_jefe[0]->ANTECESOR == 1 || $dependencia_jefe[0]->ANTECESOR == 2 || $dependencia_jefe[0]->ANTECESOR == 3 || $dependencia_jefe[0]->ANTECESOR == 4 || $dependencia_jefe[0]->ANTECESOR == 5 || $dependencia_jefe[0]->ANTECESOR == 6){
			$user_dep = $this->M_revision->usuarios_dependencia_antecesor_funcionarios($dependencia_jefe[0]->CODIGO_DEPENDENCIA, $this->session->userdata('identificacion'));
		  
			if(count($user_dep) <= 0){
				$user_dep = $this->M_revision->usuarios_dependencia_funcionarios($dependencia_jefe[0]->CODIGO_DEPENDENCIA, $this->session->userdata('identificacion'));
			}
		}else{
			$user_dep = $this->M_revision->usuarios_dependencia_antecesor_contratistas($dependencia_jefe[0]->CODIGO_DEPENDENCIA, $this->session->userdata('identificacion'));
		  
			if(count($user_dep) <= 0){
				$user_dep = $this->M_revision->usuarios_dependencia_contratistas($dependencia_jefe[0]->CODIGO_DEPENDENCIA, $this->session->userdata('identificacion'));
			}
		}*/
	
		$user_dep = $this->M_revision->usuarios_dependencia_antecesor_todos($dependencia_jefe[0]->CODIGO_DEPENDENCIA, $this->session->userdata('identificacion'));
	  
		if(count($user_dep) <= 0){
			$user_dep = $this->M_revision->usuarios_dependencia_todos($dependencia_jefe[0]->CODIGO_DEPENDENCIA, $this->session->userdata('identificacion'));
		}
		
	
		
		
		?>
		<div>

		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#previsar" aria-controls="previsar" role="tab" data-toggle="tab">Informes por revisar</a></li>
			<li role="presentation"><a href="#aprobadas" aria-controls="aprobadas" role="tab" data-toggle="tab">Informes Aprobados</a></li>
			<li role="presentation"><a href="#ajustes" aria-controls="ajustes" role="tab" data-toggle="tab">Informes en ajustes</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
			<!--PANEL POR LEGALIZAR-->
			<div role="tabpanel" class="tab-pane active" id="previsar">
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
							
							$archivos = $this->M_revision->archivos_comision($listado_com_todos[0]->id_datos); 
							$ar_rutas = $this->M_revision->archivos_comision_rutas($listado_com_todos[0]->id_datos); 
							    

							$NOMBRE = $listado_com[0]->NOMBRE;
							$OBJETO = $listado_com[0]->OBJETO;
							$FECHA_INICIAL = $listado_com[0]->FECHA_INICIAL;
							$FECHA_FINAL = $listado_com[0]->FECHA_FINAL;
							$LUGAR_COMISION = $listado_com[0]->LUGAR_COMISION;

							if($id % 2 == 0){
								$class = "style='background-color:#E9E9E9'";
							}else{
								$class = "style='background-color:#FFFFFF'";
							}
							
							if(isset($estado[0]) && $estado[0]->id_estado == 1){
							?>
							<div class="row" <?= $class?>>
								<form class="form-horizontal formRevision" enctype="multipart/form-data" action="<?php echo base_url('index.php/revision/guardarEstado');?>" method="post" id="formReg<?= $id?>" name="formReg<?= $id?>">
								<div class="row">
									<div class="col-md-8">
										<div class="col-md-10 col-md-offset-1">
											<div class="col-md-8">  
												<p class="text-justify"><b>Nombre: </b><?php echo $user_dep[$i]->NOM_USUARIO." ".$user_dep[$i]->APE_USUARIO?></p>
											</div>
											<div class="col-md-4">
												<p  class="text-justify"><b>Cedula:</b><?php echo $user_dep[$i]->NUM_IDENT?></p>
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
									<div class="col-md-4"> 
										<div class="col-md-8 col-md-offset-2">
											<p><a href="<?php echo base_url('index.php/revision/generaWord/'.$listado_com_todos[0]->id_datos)?>"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Ver Informe</a></p>  
											<p> 
												<input type="hidden" name="id_datos" id="id_datos" value="<?= $listado_com_todos[0]->id_datos?>">
												<select class="form-control validate[required]" id="estado<?= $id?>" name="estado" onchange="validarEstado(<?= $id?>)">
													<option value="">Seleccione...</option>
													<?php												
													for($es = 0;$es<count($estados);$es++){
														echo "<option value='".$estados[$es]->id_estado."'>".$estados[$es]->estado."</option>";
													}
													
													?>
												</select>										
											</p>
											<p>
												<textarea rows="3" name="observaciones" id="observaciones" placeholder="Observaciones" class="form-control validate[required]"></textarea>   
											</p>
											<p><button type="submit" class="btn btn-lg btn-success btn-block" value="<?php echo $id?>">Guardar</button></p>										
										</div>
									</div>
								</div>	
								<?php
								  
								if(count($archivos) > 0 || count($ar_rutas) > 0){ 
									?>
									<div class="row">
										<div class="col-md-10 col-md-offset-1">
											
											<?php
											if(count($archivos) > 0){
												?>
												<h2>Anexos</h2>
												<?php
												for($an = 0;$an<count($archivos);$an++){
													?>
														<p><a href="<?php echo $archivos[$an]->archivo_ruta."/".$archivos[$an]->archivo?>" target="_blank"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> <?php echo $archivos[$an]->archivo?></a></p>
													<?php
												}
											}
											
											if(count($ar_rutas) > 0){  
												?>
												<h2>Anexos Rutas</h2>
												<?php
												for($ar = 0;$ar<count($ar_rutas);$ar++){
													?>
													<p><a href="<?php echo $ar_rutas[$ar]->archivo_ruta."/".$ar_rutas[$ar]->archivo?>" target="_blank"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> <?php echo $ar_rutas[$ar]->archivo?></a></p>													
													<?php
												}
											}
											?>
											
										</div>
									</div>
									<?php
								} 
								?>																
								<div id="div_doc<?= $id?>" class="row" style="display:none">
									<div class="col-md-8 col-md-offset-2">
										<h2>Por favor adjunte el documento (.doc, .docx, .pdf, .jpg).</h2>
										<input id="docAjustes" name="docAjustes" class="file file-loading validate[required]" type="file" data-show-upload="false" data-show-caption="true" data-show-preview="true" data-show-remove="false" data-allowed-file-extensions='["doc","docx","pdf","jpg"]' >	 		  							
										<br><br>
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
			<!--PANEL Aprobadas-->
			<div role="tabpanel" class="tab-pane" id="aprobadas">
			
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
								$class = "style='background-color:#E9E9E9'";
							}else{
								$class = "style='background-color:#FFFFFF'";
							}
							
							if(isset($estado[0]) && $estado[0]->id_estado == 2){
							?>
							<div class="row" <?= $class?>>
								<form class="form-horizontal formRevision" enctype="multipart/form-data" action="<?php echo base_url('index.php/revision/guardarEstado');?>" method="post" id="formReg<?= $id?>" name="formReg<?= $id?>">
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
			<!--PANEL  ajustes-->
			<div role="tabpanel" class="tab-pane" id="ajustes">
			
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
								$class = "style='background-color:#E9E9E9'";  
							}else{
								$class = "style='background-color:#FFFFFF'";
							}
							
							if(isset($estado[0]) && $estado[0]->id_estado == 3){
							?>
							<div class="row" <?= $class?>>
								<form class="form-horizontal formRevision" enctype="multipart/form-data" action="<?php echo base_url('index.php/revision/guardarEstado');?>" method="post" id="formReg<?= $id?>" name="formReg<?= $id?>">
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
	}else{
		
	}
	
}else {
    echo redirect(base_url("index.php/login/iniciar_sesion"));
} ?>
