<?php if ($this->session->userdata('logueado')) { ?>
    <ol class="breadcrumb">
        <li><a href="http://192.168.1.200/gestion_conocimiento/">Inicio</a></li>
        <li class="active">El DANE quiere conocerte</li>
    </ol>
    <?php if ($error == "exito") { ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Exito!</strong> se creo correctamente el perfil.
        </div>
    <?php } ?>
    <?php if ($error == "editar") { ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Exito al editar!</strong> se edito correctamente el perfil.
        </div>
    <?php } ?>
    <div>
        <h2>El DANE quiere conocerte: tu perfil institucional</h2>
        <p>&nbsp;</p>
        <p>Para una adecuada gestión del conocimiento en el DANE, es primordial identificar cuáles son las necesidades de sus colaboradores, así como sus conocimientos y habilidades. Por eso, queremos invitarte a que completes tu perfil y nos cuentes cuáles son los saberes y experiencias que posees y que pueden aportar al logro de los objetivos institucionales.</p>
        <p>Para empezar, debes diligenciar el aplicativo <b>“Queremos saber más de ti”</b>, del Área de Gestión Humana de la entidad (haz clic <a href="http://danenet.dane.gov.co/ghumana/login" target="_black">aquí</a>). La información que ingreses allí aparecerá precargada en nuestro portal. Luego, completa tu perfil con la información adicional que te pedimos.</p>
        <p>&nbsp;</p>
    </div>
    <?php echo form_open('', 'enctype="multipart/form-data" id="defaultForm"'); ?>
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

                    <h3><b>Identificación de tus saberes y habilidades:</b></h3>
                    <p>Para nosotros es muy importante identificar cuáles son tus habilidades y en qué puedes aportar para la gestión de los procesos de la entidad. Por eso, te invitamos para que selecciones las categorías y subcategorías a las que puedas o quisieras contribuir, según tu experiencia laboral en otras entidades y en el DANE, tu formación académica y fortalezas en general.</p>
                    <p>Recuerda que puedes consultar en qué consisten estas categorías en la sección <a href="http://192.168.1.200/gestion_conocimiento/?q=content/ayuda" target="_black">Ayuda</a> del portal.</p><br />
                    <p><b>Categorías de la gestión de procesos</b><br />Selecciona <b>la</b> o <b>las categorías</b> a las que puedas aportar, para seleccionar más de una categoría debes seleccionarlas oprimiendo el botón del teclado Ctrl.</p>

                    <select name="categorias[]" id="categorias" class="form-control" multiple="" onchange="carga_ajax('<?php echo base_url(); ?>index.php/perfil/subcategorias', $(this).val(), 'SubcategoriasConocimmiento')">
                        <option value="">Seleccione</option>
                        <?php foreach ($categorias as $IdCategoria => $Categoria) { ?>
                            <option value="<?php echo $Categoria->id_categoria; ?>"><?php echo $Categoria->categoria; ?></option>
                        <?php } ?>
                    </select><br />

                    <p><b>Subcategorías de la gestión de procesos</b><br />Selecciona <b>una</b> o <b>varias subcategorías</b> a las que puedas aportar.</p>

                    <div id="SubcategoriasConocimmiento"></div><br />

                    <p><b>Descripción de tu posible aporte</b><br />Explica por qué consideras que puedes contribuir a estas categorías y subcategorías.</p>
                    <textarea class="form-control" name="aporte" id="aporte" rows="3" cols="40" placeholder=""></textarea>

                    <h3><b>Software que manejo:</b></h3>

                    <h3>Programas estadísticos:</h3>
                    <div class="checkbox">
                        <label>
                            <input value="R" type="checkbox" name="Sw[]" /> R
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="STATA" type="checkbox" name="Sw[]" /> STATA
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="SAS" type="checkbox" name="Sw[]" /> SAS
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="SPSS" type="checkbox" name="Sw[]" /> SPSS
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Excel" type="checkbox" name="Sw[]" /> Excel
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="MATLAB" type="checkbox" name="Sw[]" /> MATLAB
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="STATGRAPHICS" type="checkbox" name="Sw[]" /> STATGRAPHICS
                        </label>
                    </div>
                    <h3>Programas de diseño:</h3>
                    <div class="checkbox">
                        <label>
                            <input value="Adobe Photoshop" type="checkbox" name="Sw[]" /> Adobe Photoshop
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Adobe Illustrator" type="checkbox" name="Sw[]" /> Adobe Illustrator
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Adobe Indesign" type="checkbox" name="Sw[]" /> Adobe Indesign
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Adobe Fireworks" type="checkbox" name="Sw[]" /> Adobe Fireworks
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Adobe Muse" type="checkbox" name="Sw[]" /> Adobe Muse
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Adobe LightRoom" type="checkbox" name="Sw[]" /> Adobe LightRoom
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="CorelDraw" type="checkbox" name="Sw[]" /> CorelDraw
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Adobe Acrobat Pro" type="checkbox" name="Sw[]" /> Adobe Acrobat Pro
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Sketch" type="checkbox" name="Sw[]" /> Sketch
                        </label>
                    </div>
                    <h3>Animación y video:</h3>
                    <div class="checkbox">
                        <label>
                            <input value="Adobe After Effects" type="checkbox" name="Sw[]" /> Adobe After Effects
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="ToonBoom" type="checkbox" name="Sw[]" /> ToonBoom
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Adobe Indesign" type="checkbox" name="Sw[]" /> Adobe Indesign
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Adobe Premier Pro" type="checkbox" name="Sw[]" /> Adobe Premier Pro
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Cinema 4D" type="checkbox" name="Sw[]" /> Cinema 4D
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Adobe Flash" type="checkbox" name="Sw[]" /> Adobe Flash
                        </label>
                    </div>
                    <h3>Modelación 3D</h3>
                    <div class="checkbox">
                        <label>
                            <input value="Rhinoceros" type="checkbox" name="Sw[]" /> Rhinoceros
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Autodesk 3ds Max" type="checkbox" name="Sw[]" /> Autodesk 3ds Max
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="Autodesk Maya" type="checkbox" name="Sw[]" /> Autodesk Maya
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="ZBrush" type="checkbox" name="Sw[]" /> ZBrush
                        </label>
                    </div>

                    Otro. ¿Cuál?
                    <input type="text" name="Sw[]" id="Sw" class="form-control" />

                <!--<table id="Tblsw" class="table">
                <thead>
                <tr>
                <th>Nombre del software</th>
                <th>&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                    <!-- fila base para clonar y agregar al final -->
                    <!--<tr class="fila-base-sw">
                        <td>
                            <input type="text" name="Sw[]" id="sw" value="" class="form-control" placeholder="Escribe el nombre del software que manejas." />
                        </td> 
                        <td class="eliminarsw">Eliminar</td>
                    </tr>
                    <!-- fin de código: fila base -->

                    <!-- Fila de ejemplo -->
                    <!--<tr>
                        <td>
                            <input type="text" name="Sw[]" id="sw" value="" class="form-control" placeholder="Escribe el nombre del software que manejas." />
                        </td>
                        <td class="eliminarsw">Eliminar</td>
                    </tr>
                    <!-- fin de código: fila de ejemplo -->
                    <!--</tbody>
                </table>
                    <!-- Botón para agregar filas -->
                    <!--<input type="button" id="agregarsw" class="btn btn-default" value="Agregar otro" />-->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <button name="btn_enviar" class="btn btn-primary edit-button" type="submit">Guardar</button>
        </div>
    </div>
    <?php echo form_close(); ?>
    <?php
} else {
    echo redirect(base_url("index.php/login/iniciar_sesion"));
}
?>