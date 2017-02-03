<h2 class="text-center">Bienvenido al Portal de Gestión del Conocimiento</h2>
<h4 class="text-center">Debes ingresar con tu usuario y contraseña de red</h4>
<div class="form-wrapper">
    <?php
    if (isset($errorLogin) && strlen($errorLogin) > 0) {
        ?>
        <div class="alert alert-danger"> 
            <strong>¡Error!</strong> <?php echo $errorLogin; ?>
        </div>
    <?php } ?>
    <form class="form-signin" method="post" id="inguser" action="<?php echo site_url("login/userValidation"); ?>">
        <div class="form-group">
            <label for="inputLogin" >Usuario</label>
            <div class="input-wrapper user-icon">
                <input type="text" id="inputLogin" name="inputLogin" class="form-control" placeholder="Usuario" required autofocus />
            </div>
        </div>		
        <div class="form-group">
            <label for="inputPassword" >Contraseña</label>
            <div class="input-wrapper key-icon">
                <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Contraseña" required />
            </div>
        </div>
        <button type="submit" id="btnIngresar" name="btnIngresar" class="btn btn-primary btn-block">Ingresar</button>
    </form>
</div>

<div class="contact">
    <p class="small text-center">Si no puedes ingresar, por favor comunícate con el Grupo Área de Innovación y Aprendizaje - GAIA al correo electrónico <a href="mailto:innovacion_aprendizaje@dane.gov.co">innovacion_aprendizaje@dane.gov.co</a> o a las extensiones 2030, 2025 o 2399.</p>
</div>