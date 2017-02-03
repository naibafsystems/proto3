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
	
	<h1>¡Ya te encuentras inscrito! Pr&oacute;ximamente te llegar&aacute; la confirmaci&oacute;n a tu correo electr&oacute;nico para que puedas ingresar y cumplir con tu "Misi&oacute;n estad&iacute;stica". </h1> 
	<p class="text-justify"><br/>"Misión estadística", nuestro programa de inducci&oacute;n institucional, no solo est&aacute; orientado a los nuevos funcionarios del DANE, sino que tambi&eacute;n est&aacute; dirigido a todas las generaciones de colaboradores que quieran actualizarse y, ¿por qu&eacute; no?, poner a prueba sus conocimientos sobre nuestra entidad.</p>
		