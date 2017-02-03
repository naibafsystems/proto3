<h1 class="text-center">Ingreso Usuario</h1><br />
<div class="row">
	<!--[if lt IE 9]>
	<table align="center" width="50%">
		<tr>
			<td>
	<![endif]-->
			<div class="col-md-6 col-md-offset-3" >			
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Ingreso de Usuarios</h3>
					</div>
					<div class="panel-body">
						<?php
						if (isset($errorLogin) && strlen($errorLogin) > 0) { 
						?>
						<div class="alert alert-danger"> 
							<strong>¡Error!</strong> <?php echo $errorLogin; ?>
						</div>
						<?php } ?>
						<form class="form-signin" method="post" action="<?php echo site_url("login/userValidation"); ?>">
                            <div class="form-group">
                                <label for="inputLogin" >Usuario</label>
                                <input type="text" id="inputLogin" name="inputLogin" class="form-control" placeholder="Usuario" required autofocus />
                            </div>		
							<div class="form-group">
    							<label for="inputPassword" >Contraseña</label>
    							<input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Contraseña" required />
                            </div>
                            <div class="form-group">
    							<label for="inputDocumento" >Contraseña</label>
    							<input type="text" id="inputDocumento" name="inputDocumento" class="form-control" placeholder="Numero de Documento" required />
                            </div>
							<button type="submit" id="btnIngresar" name="btnIngresar" class="btn btn-primary btn-block">Ingresar</button>
						</form>
					</div>
				</div>			
			</div>
	<!--[if lt IE 9]>
			</td>
		</tr>
	</table>
	<![endif]-->
</div> 