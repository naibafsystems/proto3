    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li class="active">Reporte inscripci&oacute;n curso inducci&oacute;n</li>
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
		
	<table class="table">
		<thead>
			<tr>
				<th>Cedula</th>
				<th>Nombres</th>
				<th>Apellidos</th>
				<th>Correo Institucional</th>
				<th>Territorial</th>
				<th>Ciudad</th>
				<th>Grupo</th>
				<th>Tipo Vinculaci&oacute;n</th>
				<th>Fecha Vinculaci&oacute;n</th>
				<th>Fecha Finalizaci&oacute;n</th>
			</tr>
		</thead>
		<tbody>
			<?php
			
			for($i=0;$i<count($inscritos);$i++){
				?>
				<tr>
					<td><?php echo $inscritos[$i]->identificacion?></td>
					<td><?php echo $inscritos[$i]->nombres?></td>
					<td><?php echo $inscritos[$i]->apellidos?></td>
					<td><?php echo $inscritos[$i]->email?></td>
					<td><?php echo $inscritos[$i]->desc_territorial?></td>
					<td><?php echo $inscritos[$i]->desc_ciudad?></td>
					<td><?php echo $inscritos[$i]->grupo?></td>
					<td><?php echo $inscritos[$i]->desc_tipocont?></td>
					<td><?php echo $inscritos[$i]->fecha_vinc?></td>
					<td><?php echo $inscritos[$i]->fecha_fin?></td>
				</tr>
				<?php	
			}			
			?>
		</tbody>
	</table>	