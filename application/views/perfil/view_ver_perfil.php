<?php if ($this->session->userdata('logueado')) { ?>
    <ol class="breadcrumb">
        <li><a href="http://192.168.1.200/gestion_conocimiento/">Inicio</a></li>
        <li class="active">El DANE quiere conocerte</li>
    </ol>
    <div>
        <h2>El DANE quiere conocerte: tu perfil institucional</h2>
        <p>&nbsp;</p>
        <p>Para una adecuada gestión del conocimiento en el DANE, es primordial identificar cuáles son las necesidades de sus colaboradores, así como sus conocimientos y habilidades. Por eso, queremos invitarte a que completes tu perfil y nos cuentes cuáles son los saberes y experiencias que posees y que pueden aportar al logro de los objetivos institucionales.</p>
        <p>Para empezar, debes diligenciar el aplicativo <b>“Queremos saber más de ti”</b>, del Área de Gestión Humana de la entidad (haz clic <a href="http://danenet.dane.gov.co/ghumana/login" target="_black">aquí</a>). La información que ingreses allí aparecerá precargada en nuestro portal. Luego, completa tu perfil con la información adicional que te pedimos.</p>
        <p>&nbsp;</p>
    </div>
    <?php if ($error != "") { ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Para empezar!</strong> ,debes diligenciar el aplicativo “Queremos saber más de ti”, del Área de Gestión Humana de la entidad (haz clic <a href="http://danenet.dane.gov.co/ghumana/login" target="_black">aquí</a>). La información que ingreses allí aparecerá precargada en nuestro portal. Luego, completa tu perfil con la información adicional que te pedimos..
        </div>
    <?php } else { ?>

        <div class="row">
            <div class="col-md-2 text-center profile-pic">
                <?php if ($datos_perfil[0]->IMAGEN != null) { ?>
                    <img src="http://danenet.dane.gov.co/ghumana/files/funcionarios/thumbs/<?php echo $datos_perfil[0]->IMAGEN; ?>" alt="Image perfil" width="120px" class="img-circle"><br />
                <?php } else { ?>
                    <img src="<?php echo base_url(); ?>public/images/default_perfil.png" alt="Image perfil" width="110px" class="img-circle"><br />
                <?php } ?>
            </div>
            <div class="col-md-10">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Tu información de contacto</a>
                    </li>
                    <li role="presentation">
                        <a href="#saberes" aria-controls="profile" role="tab" data-toggle="tab">Tus saberes y habilidades</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home"><br />
                        <h4>Nombre:</h4>
                        <dd><?php echo $this->session->name; ?></dd>
                        <h4>Correo electrónico:</h4>
                        <dd><?php echo $this->session->mail; ?></dd>
                        <h4>Despacho:</h4>
                        <dd><?php echo ucfirst(strtolower($despacho[0]->DESCRIPCION)); ?></dd>
                        <h4>Dependencia:</h4>
                        <dd><?php echo ucfirst(strtolower($dependencia[0]->DESCRIPCION)); ?></dd>
                        <h4>Grupo:</h4>
                        <dd><?php echo ucfirst(strtolower($grupo[0]->DESCRIPCION)); ?></dd>
                        <h4>Teléfono:</h4>
                        <dd><?php echo $datos_perfil[0]->TEL_USUARIO; ?></dd>
                        <h4>Extensión:</h4>
                        <dd><?php echo $datos_perfil[0]->EXT_USUARIO; ?></dd>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="saberes"><br />
                        <h3><b>Formación académica</b></h3>
                        <?php
                        foreach ($datos_estudios as $valor) {
                            echo "<p>" . $valor->NIVEL_ESTUDIO . ": <br>" . $valor->TITULO . " (" . $valor->ANNO . ")</p>";
                        }
                        ?>

                        <h3><b>Idiomas</b></h3>
                        <?php
                        foreach ($datos_idiomas as $valor) {
                            echo "<p>" . $valor->IDIOMA . " - Habla: " . $valor->HABLA . " - Lee: " . $valor->LEE . " - Escribe: " . $valor->ESCRIBE . "</p>";
                        }
                        ?>
                        
                        <h3><b>Categorías de la gestión de procesos</b></h3>
                        <?php
                            foreach ($categorias as $valor) {
                                echo $valor->subcategoria . ",";
                            }
                        ?>
                        
                        <h3><b>Descripción de tu posible aporte:</b></h3>
                        <?php
                            if (!empty($aporte[0]->posible_aporte)) {
                                echo $aporte[0]->posible_aporte;
                            }
                        ?>
                        
                        <h3><b>Software que manejo:</b></h3>
                        <?php
                            foreach ($sofware as $valor) {
                                echo $valor->software . ",";
                            }
                        ?>
                        
                    </div>
                </div>
                <a href="<?php echo base_url(); ?>index.php/perfil/edit" class="btn btn-primary edit-button">Editar</a>
            </div>
        </div>
    <?php } ?>
    <?php
} else {
    echo redirect(base_url("index.php/login/iniciar_sesion"));
}
?>