<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Comisiones</title>
    
        <!-- Bootstrap -->
        <link href="<?php echo base_url();?>public/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>public/css/bootstrap-theme.min.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>public/css/theme.css" rel="stylesheet" />
    
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body role="document">
        <!-- Fixed navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php echo base_url();?>index.php">Comisiones</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo base_url();?>index.php">Inicio</a></li>
                <li><a href="<?php echo base_url();?>index.php/comisiones">Comisiones</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrar <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url();?>index.php/comision">Comisiones</a></li>
                    <li><a href="<?php echo base_url();?>index.php/tema">Tema</a></li>
                    <li role="separator" class="divider"></li>
                  </ul>
                </li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>
        <div class="container theme-showcase" role="main">                        
            <div class="page-header">
                <h1>Comisiones</h1>
    
                <p>Guia CodeIgniter <a href="user_guide/">User Guide</a>.</p>
            </div>
        </div>
        <script src="<?php echo base_url();?>public/js/jquery-1.12.3.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url();?>public/js/bootstrap.min.js"></script>
    </body>
</html>

		
	