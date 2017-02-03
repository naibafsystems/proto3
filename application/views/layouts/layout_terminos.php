<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
                <a href="#">
                    <div class="col-sm-8 col-md-6 hidden-xs" id="dane-logo">
                        <img src="<?php echo base_url(); ?>public/images/logo_dane-2.jpg" class="img-responsive" alt="Logo Dane">
                    </div>
                </a>
                <div class="col-xs-12 visible-xs" id="dane-logo">
                    <img src="<?php echo base_url(); ?>public/images/logo_dane_mobile.png" class="img-responsive" alt="Logo Dane">
                </div>
                <form>
                    <input class="search-box" type="text" placeholder="Buscar" readonly="" />
                </form>
                <div class="perfil">
                    <ul>
                        <li><a href="#"><?php echo $this->session->name; ?></a></li>
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
                        <li><a href="#" class="active-trail active">Inicio</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Emprende un buen comienzo <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="first leaf"><a href="#">Tu bienvenida al DANE</a></li>
                                <li class="last leaf"><a href="#">El DANE quiere conocerte</a></li>
                            </ul>
                        </li>
                        <li class="expanded dropdown"><a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Comparte saberes y experiencias <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="first leaf"><a href="#">Tu participación en comisiones</a></li>
                                <li class="leaf"><a href="#">Tu aporte a la gestión estadística</a></li>
                                <li class="last leaf"><a href="#">La historia detrás del dato</a></li>
                            </ul>
                        </li>
                        <li class="expanded dropdown"><a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Aprende en comunidad <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="first last leaf"><a href="#">Comunidades de aprendizaje</a></li>
                                <li class="first last leaf"><a href="#">Inventario de innovaciones</a></li>
                            </ul>
                        </li>
                        <li class="leaf"><a href="#">Descubre lo que otros saben</a></li>
                        <li class="last leaf"><a href="#">Ayuda</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container-fluid">   
            <div class="row content">
                <div class="col-sm-12 text-left">
                    <?php
                    if ($this->session->userdata('logueado')) {
                        echo @$template['body'];
                    } else {
                        echo redirect(base_url("index.php/login/iniciar_sesion"));
                    }
                    ?>
                </div>
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