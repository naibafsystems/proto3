<!doctype html>
<html>
	<head>
		<style type="text/css">
			body {
			 background-color: #fff;
			 margin: 400px;
			 font-family: Lucida Grande, Verdana, Sans-serif;
			 font-size: 14px;
			 color: #4F5155;
			}
			
			table {
			  border-collapse: separate;
			  border-spacing:  15px;
			}
			
			p {text-align:justify;font-size: 12pt;}
		</style>
	</head>
	<body>
		<table border="0">
			<tr>
				<td width="100px"><b>TITULO DEL PROYECTO</b></td>
				<td width="400px"><p><?php echo $proyecto -> titulo_proyecto; ?></p></td>
			</tr>
			<tr>
				<td width="100px"><b>LINEA DE ACCI&Oacute;N</b></td>
				<td width="400px"><p><?php echo $reto_proyecto[0] -> descripcion_liac; ?></p></td>
			</tr>
			<tr>
				<td width="100px"><b>RETO</b></td>
				<td width="400px"><p><?php echo $reto_proyecto[0] -> nombre_reto; ?></p></td>
			</tr>
			<tr>
				<td width="100px"><b>FECHA DE REGISTRO</b></td>
				<td width="400px"><p><?php echo $proyecto -> fecha_registro; ?></p></td>
			</tr>
			<tr>
				<td width="100px"><b>OBJETIVO GENERAL</b></td>
				<td width="400px"><p><?php echo $proyecto -> objetivoGral; ?></p></td>
			</tr>
			<tr>
				<td width="100px"><b>OBJETIVO ESPEC&Iacute;FICO</b></td>
				<td width="400px"><p><?php echo $proyecto -> objetivoEsp; ?></p></td>
			</tr>		
			<tr>
				<td width="100px"><b>JUSTIFICACI&Oacute;N DEL PROYECTO</b></td>
				<td width="400px"><p><?php echo $proyecto -> justificacion; ?></p></td>
			</tr>
			<tr>
				<td width="100px"><b>METODOLOG&Iacute;A DEL PROYECTO</b></td>
				<td width="400px"><p><?php echo $proyecto -> metodologia; ?></p></td>
			</tr>
			<tr>
				<td width="100px"><b>PLAN DE TRABAJO</b></td>
				<td width="400px"><p><?php echo $proyecto -> plan_trabajo; ?></p></td>
			</tr>
			<tr>
				<td width="100px"><b>PRESUPUESTO</b></td>
				<td width="400px"><p><?php echo $proyecto -> presupuesto; ?></p><p><?php echo $proyecto -> presupuesto_descripcion; ?></p></td>
			</tr>
			<tr>
				<td width="100px"><b>PRODUCTO</b></td>
				<td width="400px"><p><?php echo $proyecto -> producto; ?></p></td>
			</tr>
			<tr>
				<td width="100px"><b>GLOSARIO</b></td>
				<td width="400px"><p><?php echo $proyecto -> glosario; ?></p></td>
			</tr>
			<tr>
				<td width="100px"><b>REFERENCIAS BIBLIOGRAFICAS</b></td>
				<td width="400px"><p><?php echo $proyecto -> refbiblio; ?></p></td>
			</tr>
		</table>
	</body>
</html>