<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo @$template['title']; ?></title>
        <link href="<?php echo base_url(); ?>public/images/favicon2.png" rel="shortcut icon" type="image/vnd.microsoft.icon">
        
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto+Slab" rel="stylesheet" type="text/css">
        
        <meta name="description" content="<?php //echo $this->layout->getDescripcion(); ?>">
		<meta name="keywords" content="<?php //echo $this->layout->getKeywords(); ?>" />
        
        <!-- Bootstrap -->
        <link href="<?php echo base_url();?>public/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>public/css/bootstrap-theme.min.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>public/css/font-awesome.min.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>public/css/custom.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>public/css/custom2.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>public/css/personal.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>public/css/temp-styles.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>public/css/bootstrapValidator.min.css" rel="stylesheet" />
    
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body role="document">
            <div class="container-fluid">
    
                <div class="row full-width-row">
                    <div>
                        <div class="col-sm-6 col-md-7 col-lg-8 big-image w-h-1 hidden-xs">
                        </div>
                        <div class="col-sm-6 col-md-5 col-lg-4 w-h-2">
                            <div class="logo-wrapper">
                                <h1 class="text-hide">Departamento Administrativo Nacional de Estad�stica - Portal Gesti�n del Conocimiento</h1>
                            </div>
                        
                            <div class="row login" id="colorbar">
                                <div id="color_container">
                                    <div id="area11" class="color5"></div>
                                    <div id="aread">
                                        <div id="area12" class="color3"></div>
                                        <div id="area13" class="color6"></div>
                                    </div>
                                    <div id="area14" class="color4"></div>
                                    <div id="areae">
                                       <div id="area15" class="color1"></div>
                                       <div id="area16" class="color3"></div>
                                    </div>
                                    <div id="areaf">
                                        <div id="area17" class="color3"></div>
                                        <div id="area18" class="color2"></div>
                                        <div id="area19" class="color5"></div>
                                    </div>
                                    <div id="areag">
                                        <div id="area20" class="color6"></div>
                                        <div id="area21" class="color3"></div>
                                    </div>
                                    <div id="area22" class="color1"></div>
                                </div>
                            </div>
                            <div class="row gray-box">
        
                                <?php echo @$template['body']; ?>
                    
                            <div class="legal">
                                <p class="text-center">DANE @ 2016. Todos los derechos reservados | <a href="#">T&eacute;rminos de uso</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url();?>public/js/jquery-1.12.3.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url();?>public/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>public/js/bootstrapValidator.min.js"></script>
        <?php echo @$template['metadata']; //echo $this->layout->css; ?>
    </body>
</html>