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
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
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
        <link href="<?php echo base_url(); ?>public/js/datatables.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>public/css/temp-styles.css" rel="stylesheet" />

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
                        <li><a href="<?php echo $urlSomos; ?>?q=inicio" class="active-trail active">Inicio</a></li>
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
                                <h3>Comisiones</h3>
                                <p>En este espacio podrás compartir el conocimiento y experiencia que has adquirido en tus comisiones. También podrás ver y opinar acerca de las vivencias de cada uno de tus compañeros.</p>
                                <p>Haz clic en cada uno de los siguientes ítems para descubrir más.</p>
                            </div>
                            <a href="<?php echo base_url(); ?>index.php/comisiones/propias" class="list-group-item">
                                Comparte tu comisión
                            </a>
                            <a href="<?php echo base_url(); ?>index.php/comisiones" class="list-group-item">
                                Conoce las comisiones de otros
                            </a>
                            <!--<a href="<?php echo base_url(); ?>index.php/palabras/propias" class="list-group-item">
                                 Gestiona tu conocimiento
                            </a>-->
                            <a href="<?php echo base_url(); ?>index.php/palabras/index/1/p" class="list-group-item">
                                Analiza las comisiones
                            </a>
							<a href="<?php echo base_url(); ?>index.php/revision/revisa" class="list-group-item">
                                 Revisi&oacute;n de comisiones 
                            </a>
							<a href="<?php echo base_url(); ?>index.php/revision/" class="list-group-item">
                                 Legalizaci&oacute;n de comisiones  
                            </a>
                        </div>     
                    </div>   
                    <div class="row">
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
                            <!--<a href="<?php echo base_url(); ?>index.php/vistas" class="list-group-item">
                                <i class="fa fa-eye"></i> Comisiones vistas
                            </a>-->
                            <a href="<?php echo base_url(); ?>index.php/palabras/analisis" class="list-group-item">
                                Gestiona el conocimiento
                            </a>
                        </div>     
                    </div>   
                    <?php if ($this->session->userdata['admin']) { ?>
                        <div class="row">
                            <div class="mini-submenu">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </div>
                            <div class="list-group">
                                <span href="#" class="list-group-item active">Administración</span>
                                <a href="<?php echo base_url(); ?>index.php/Admin/noejecutadas" class="list-group-item">
                                    Comisiones no ejecutadas.
                                </a>
                            </div>     
                        </div>   
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
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery-1.12.3.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
<?php echo @$template['metadata']; ?>
    </body>
</html>