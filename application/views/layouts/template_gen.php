<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo $this->layout->getTitle(); ?></title>
        
        <meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
		<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />
        
        <!-- Bootstrap -->
        <link href="<?php echo base_url();?>public/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>public/css/bootstrap-theme.min.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>public/css/font-awesome.min.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>public/css/custom.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>public/css/custom2.css" rel="stylesheet" />
    
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!--*************auxiliares*****************-->
        <?php echo $this->layout->css; ?> 
        <!--**********fin auxiliares*****************-->
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
              <a class="navbar-brand" href="<?php echo base_url();?>index.php/comisiones">Comisiones</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li><a href="<?php echo base_url();?>index.php/comisiones">Inicio</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Comisiones <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url();?>index.php/comisiones">Comisiones</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo base_url();?>index.php/comisiones/propias">Comisiones Propias</a></li>
                  </ul>
                </li>
                <!--<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrar <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url();?>index.php/comision">Comisiones</a></li>
                    <li><a href="<?php echo base_url();?>index.php/tema">Tema</a></li>
                    <li role="separator" class="divider"></li>
                  </ul>
                </li>-->
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url();?>index.php/login/cerrar_sesion">Cerrar Sesi&oacute;n</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>
        <div class="container theme-showcase" role="main">                        
            <div class="page-header">
        
                <?php echo $content_for_layout; ?>
        
            </div>
        </div>
        <footer class="footer">
        	<div class="container">
        		<div class="row">
        			<div class="col-xs-10">
        				<p class="text-muted">
        					DANE: Carrera 59 No. 26-70 Interior I - CAN. Conmutador (571) 5978300 - Fax (571) 5978399<br/>
        					L&iacute;nea gratuita de atenci&oacute;n 01-8000-912002. &oacute; (571) 5978300 Exts. 2532 - 2605	    		   
        	    		</p>
        			</div>    	
            	</div>
        	</div>
        </footer>
        <script src="<?php echo base_url();?>public/js/jquery-1.12.3.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url();?>public/js/bootstrap.min.js"></script>
        <!--*************auxiliares*****************-->
        <?php echo $this->layout->js; ?>
        <!--**********fin auxiliares*****************-->
    </body>
</html>