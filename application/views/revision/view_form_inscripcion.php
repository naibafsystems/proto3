    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li class="active">Inscripci&oacute;n curso inducci&oacute;n</li>
    </ol>
    
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
		
	<h1>¡Inscríbete y cumple con tu "Misi&oacute;n estad&iacute;stica"!</h1> 
    <p class="text-justify"><br/>"Misión estadística", nuestro programa de inducci&oacute;n institucional, no solo est&aacute; orientado a los nuevos funcionarios del DANE, sino que tambi&eacute;n est&aacute; dirigido a todas las generaciones de colaboradores que quieran actualizarse y, ¿por qu&eacute; no?, poner a prueba sus conocimientos sobre nuestra entidad.</p>
	<p class="text-justify"><br/>Por eso, ¡an&iacute;mate, inscr&iacute;bete y ponte a prueba!</p>
		
	<form class="form-horizontal formRevision" enctype="multipart/form-data" action="<?php echo base_url('index.php/revision/guardarInscripcion');?>" method="post" id="formInscripcion" name="formInscripcion">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<!--<div class="col-md-12">											
					<div class="col-md-12">  
						<label><b>Digita tu n&uacute;mero de documento:</label>
						<input type="text" name="doc_iden" id="doc_iden" class="form-control validate[required]">
						<button type="button" id="carga_info" class="form-control btn btn-success">Consultar</button>
					</div>				
				</div>-->
				<input type="hidden" name="doc_iden" id="doc_iden" value="<?php echo $this->session->userdata('identificacion');?>">
				<div class="col-md-12" id="divDatos" style="display:block">  
					<div class="row">
						<div class="col-md-6">
							<div class="col-md-12">  
								<p><b>Nombres:</p>
								<p><input type="text" name="nombres" id="nombres" readonly="true" value="<?php echo $datos_usuario[0]->NOM_USUARIO?>" class="form-control validate[required]"></p>
							</div>
							<div class="col-md-12">  
								<p><b>Apellidos:</p>
								<p><input type="text" name="apellidos" id="apellidos" readonly="true" value="<?php echo $datos_usuario[0]->APE_USUARIO?>" class="form-control validate[required]"></p>
							</div>
							<div class="col-md-12">  
								<p><b>Email institucional:</p>
								<p><input type="text" name="email" id="email" readonly="true" value="<?php echo $datos_usuario[0]->MAIL_USUARIO?>" class="form-control validate[required]"></p>
							</div>
							<div class="col-md-12">  
								<p><b>Grupo:</p>
								<p><input type="text" name="grupo" id="grupo" readonly="true" value="<?php echo $datos_usuario[0]->DESCRIPCION?>" class="form-control validate[required]"></p>  
							</div>
						</div>
						<div class="col-md-6">
							<div class="col-md-12">  
								<p><b>Direcci&oacute;n Territorial:</p>
								<p>
								<select name="territorial" id="territorial" class="form-control validate[required]">
									<option value=''>Seleccione...</option>
									<?php								
									for($i=0;$i<count($territoriales);$i++){
										echo "<option value='".$territoriales[$i]->id_territorial."'>".$territoriales[$i]->desc_territorial."</option>";
									}								
									?>	
								</select>	
								</p>
							</div>
							<div class="col-md-12">  
								<p><b>Ciudad:</p>
								<p>
								<select name="ciudad" id="ciudad" class="form-control validate[required]">
									<option value=''>Seleccione Territorial...</option>									
								</select>
								</p>
							</div>
							<div class="col-md-12">  
								<p><b>Tipo Vinculaci&oacute;n:</p>
								<p>
								<select name="tipo_vinc" id="tipo_vinc" class="form-control validate[required]">
									<option value=''>Seleccione...</option>
									<?php								
									for($i=0;$i<count($tipo_contrato);$i++){
										echo "<option value='".$tipo_contrato[$i]->id_tipocont."'>".$tipo_contrato[$i]->desc_tipocont."</option>";
									}								
									?>	
								</select>		
								</p>
								<p id="campo_tipo_vinc" style="display:none">
									<input type="text" name="tipo_vinc_otra" id="tipo_vinc_otra" class="form-control validate[required]" placeholder="¿Cu&aacute;l?">
								</p>
							</div>
							<div class="col-md-12">  
								<p><b>Fecha Vinculaci&oacute;n:</p>
								<p><input type="text" name="fecha_vinculacion" id="fecha_vinculacion" class="form-control datepicker validate[required]"></p>
							</div>
							<div class="col-md-12" style="display:none" id="div_ff">    
								<p><b>Fecha finalizaci&oacute;n contrato:</p>								
								<p><input type="text" name="fecha_finalizacion" id="fecha_finalizacion" class="form-control datepicker validate[required]"></p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">											
							<div class="col-md-12">  
								<button type="submit" class="form-control btn btn-warning">Confirma tu inscripci&oacute;n aqu&iacute;.</button>
							</div>				
						</div>
					</div>					
				</div>
			</div>
		</div>
	</div>										
	</form>