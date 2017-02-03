<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$urlSomos = "http://somos.dane.gov.co/";
$urlComisiones = "http://somos.dane.gov.co/comisiones";
//$urlComisiones = "http://somos.dane.gov.co/comisiones/";
/*
$urlSomos = "http://192.168.1.200/gestion_conocimiento/";
$urlComisiones = "http://192.168.1.200/gestion_conocimiento/comisiones_desa/";*/
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo @$template['title']; ?></title>

        <meta name="description" content="<?php //echo $this->layout->getDescripcion();  ?>">
        <meta name="keywords" content="<?php //echo $this->layout->getKeywords();  ?>" />

        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>public/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>public/css/bootstrap-theme.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>public/css/font-awesome.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>public/css/theme.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>public/css/custom.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>public/css/custom2.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>public/css/personal.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>public/css/temp-styles.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>public/css/bootstrapValidator.min.css" rel="stylesheet" />

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body role="document">
        <div class="container-fluid">
            <div class="topview1 row">
                <a href="<?php echo base_url(); ?>">
                    <div class="col-sm-8 col-md-6 hidden-xs" id="dane-logo">
                        <img src="<?php echo base_url(); ?>public/images/logo_dane-2.jpg" class="img-responsive" alt="Logo Dane">
                    </div>
                </a>
                <div class="col-xs-12 visible-xs" id="dane-logo">
                    <img src="<?php echo base_url(); ?>public/images/logo_dane_mobile.png" class="img-responsive" alt="Logo Dane">
                </div>
                <form>
                    <input class="search-box" type="text" placeholder="Buscar"/>
                </form>
                <div class="perfil">
                    <ul>
                        <li><a href="<?php echo $urlSomos?>?q=user"><?php echo $this->session->name; ?></a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/login/cerrar_sesion">Cerrar sesi&oacute;n</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-offset-3 col-sm-4 col-md-3"></div>
        </div>       
        <!-- Fixed navbar -->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav nav navbar-nav">
                        <li><a href="<?php echo $urlSomos?>?q=inicio" class="active-trail active">Inicio</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Emprende un buen comienzo <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="first leaf"><a href="<?php echo $urlSomos?>?q=content/tu-buen-comienzo-en-el-dane-la-induccion-institucional">Tu bienvenida al DANE</a></li>
                                <li class="last leaf"><a href="<?php echo $urlSomos?>?q=user">El DANE quiere conocerte</a></li>
                            </ul>
                        </li>
                        <li class="expanded dropdown"><a href="<?php echo $urlSomos?>?q=content/prueba" data-target="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Comparte saberes y experiencias <span class="caret"></span></a><ul class="dropdown-menu">
                                <li class="first leaf"><a href="<?php echo $urlComisiones?>index.php/comisiones">Tu participación en comisiones</a></li>
                                <li class="leaf"><a href="<?php echo $urlSomos?>?q=conocimiento-compartido">Tu aporte a la gestión estadística</a></li>
                                <li class="last leaf"><a href="<?php echo $urlSomos?>?q=memoria-dane">La historia detrás del dato</a></li>
                            </ul>
                        </li>
                        <li class="expanded dropdown"><a href="<?php echo $urlSomos?>?q=content/prueba" data-target="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Aprende en comunidad <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="first last leaf"><a href="<?php echo $urlSomos?>?q=content/introduccion-comunidades-de-aprendizaje">Comunidades de aprendizaje</a></li>
                                <li class="first last leaf"><a href="<?php echo $urlSomos?>?q=content/inventario-de-innovaciones">Inventario de innovaciones</a></li>
                            </ul>
                        </li>
                        <li class="expanded dropdown"><a href="<?php echo $urlSomos?>?q=content/prueba" data-target="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Descubre lo que otros saben <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="leaf"><a href="<?php echo $urlSomos?>?q=search/node">Guía de colaboradores</a></li>
                                <li class="leaf"><a href="<?php echo $urlSomos?>?q=content/galeria-somos-dane">Galería SOMOS DANE</a></li>
                            </ul>
                        </li>
                        <li class="last leaf"><a href="<?php echo $urlSomos?>?q=content/ayuda">Ayuda</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container-fluid">   
            <div class="row content">
                <div class="col-sm-2 sidenav">
                    <div class="row">
                        <div class="mini-submenu">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </div>
                        <div class="list-group">
                            <!--<span href="#" class="list-group-item active">Menú</span>-->
                            <div>
                                <h3>Bienvenidos al portal de Gestión del conocimiento</h3>
                                <p>Nuestro portal es un espacio para descubrir, documentar y difundir los conocimientos de los colaboradores del DANE, de manera que promovamos el aprendizaje, la innovación y la capacidad para el mejoramiento continuo de todos nuestros procesos.</p>
                                <ul>
                                    <li><a href="<?php echo $urlSomos?>?q=gestion-conocimiento">¿Qué es la gestión del conocimiento?</a></li>
                                    <li><a href="<?php echo $urlSomos?>?q=node/14">¿Con qué servicios cuenta este portal?</a></li>
                                </ul>
                            </div>
                        </div>     
                        <div class="list-group">
                            <!--<span href="#" class="list-group-item active">Menú</span>-->
                            <div>
                                <h3>¡Invita a más colaboradores!</h3>
                                <p>Si conoces a alguien que aún no haya ingresado a este portal, invítalo a formar parte de nuestra comunidad.</p>
                                <form action="/gestion_conocimiento/" method="post" id="invite-form" accept-charset="UTF-8"><div><input type="hidden" name="form_build_id" value="form-dvDDEy5RZ_5ngZ0lEp6_Lo442Q0DSswPCny457pUNFk">
                                    <input type="hidden" name="form_token" value="wM0F0-uak73Y0vQNAZ-r3ZGntv1S0GVSidCnpvR_VJM">
                                    <input type="hidden" name="form_id" value="invite_form">
                                    <div class="field-type-text field-name-field-invitation-email-address field-widget-text-textfield form-wrapper form-group" id="edit-field-invitation-email-address"><div id="field-invitation-email-address-add-more-wrapper"><div class="form-item form-item-field-invitation-email-address-und-0-value form-type-textfield form-group"> <label class="control-label" for="edit-field-invitation-email-address-und-0-value">Correo electrónico</label>
                                    <input class="text-full form-control form-text" title="" data-toggle="tooltip" type="text" id="edit-field-invitation-email-address-und-0-value" name="field_invitation_email_address[und][0][value]" value="" size="60" maxlength="255" data-original-title="Type e-mail address of person you wish invite."></div></div></div><input class="field-type-text field-name-field-invitation-email-subject field-widget-text-textfield" type="hidden" name="field_invitation_email_subject" value="">
                                    <input class="field-type-text-long field-name-field-invitation-email-body field-widget-text-textarea" type="hidden" name="field_invitation_email_body" value="">
                                    <button type="submit" id="edit-submit--2" name="op" value="Enviar invitación" class="btn btn-primary form-submit">Enviar invitación</button>
                                    </div>
                                </form>
                            </div>
                        </div>  
                    </div>   
                    <?php if ($this->session->userdata['admin']) { ?>
                        <!--<div class="row">
                            <div class="mini-submenu">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </div>
                            <div class="list-group">
                                <span href="#" class="list-group-item active">Lider</span>
                                <a href="<?php echo base_url(); ?>index.php/palabras/index/1/p" class="list-group-item">
                                    Nube de palabras
                                </a>
                                <a href="<?php echo base_url(); ?>index.php/vistas" class="list-group-item">
                                    <i class="fa fa-eye"></i> Comisiones vistas
                                </a>
                                <a href="<?php echo base_url(); ?>index.php/palabras/analisis" class="list-group-item">
                                    Gestiona el conocimiento
                                </a>
                            </div>     
                        </div>  --> 
                    <?php } ?> 
                </div>
                <div class="col-sm-10 text-left">
                    <?php
                    if ($this->session->userdata('logueado')) {
                        echo @$template['body'];
                    } else {
                        echo redirect(base_url("index.php/login/iniciar_sesion"));
                    }
                    ?>
                </div>
                <!--<div class="col-sm-2 sidenav">
                    <div class="well">
                        <p>ADS</p>
                    </div>
                    <div class="well">
                        <p>ADS</p>
                    </div>
                </div>-->
            </div>
        </div>

        <footer class="container-fluid text-center">
            <p>Departamento Administrativo Nacional de Estadística DANE<br>
                Horario de atención: Lunes a viernes 8:00 a 17:00 • Conmutador (571) 597 8300 • Fax (571) 597 8399 • Línea gratuita de atención 01 8000 912002 ó (571) 597 8300 Exts. 2532 - 2605 - 2279 - 2717<br>
                Carrera 59 No. 26-70 Interior I - CAN • Código postal 111321 • Apartado Aéreo 80043 • Bogotá D.C., Colombia - Suramérica • Términos de uso
            </p>
        </footer>
        <script src="<?php echo base_url(); ?>public/js/jquery-1.12.3.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
<?php echo @$template['metadata']; ?>
    </body>
</html>