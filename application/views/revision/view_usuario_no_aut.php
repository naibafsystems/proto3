<?php if ($this->session->userdata('logueado')) { ?>
	
    <ol class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li class="active">Legalizaci&oacute;n Comisiones</li>
    </ol>
    <h1>Usuario no autorizado para ingresar a este modulo</h1>
				
	<?php
		
}else {
    echo redirect(base_url("index.php/login/iniciar_sesion"));
} ?>
