<?php if ($this->session->userdata('logueado')) { ?>
    
    <?php 
    $lat = 4.647268;
    $lng = -74.095318;
    
    if(@$lugares[0]->latitud != null && @$lugares[0]->longitud != null){
        $lat = $lugares[0]->latitud;
        $lng = $lugares[0]->longitud;
        $estado = 1;
    }else{
        $estado = 0;
    }
    ?>
    <script type="text/javascript">

        //Variable de mapa
        var map;
        //Variable de marcador o punto
        var marcador;
        //Variable de geocodificador
        var geocoder;
        //Variable de vantana de información
        var infoWindow;
        //Variable de campo de autocompletar
        var autocompletar;
        //Variable de lugares
        var lugares;
        //Variable de ubicación inicial
        var ubicacion = {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>};

        //Función de inicialización de mapa
        function initMap() {

            //Inicializa el objeto mapa
            map = new google.maps.Map(document.getElementById("map"), {
                center: ubicacion,
                zoom: 16
            });

            //Inicializa el objeto infowindow
            infoWindow = new google.maps.InfoWindow();
            //Inicializa el objeto geocoder
            geocoder = new google.maps.Geocoder();

            //Inicializa el objeto marcador con la ubicación inicial
            marcador = new google.maps.Marker({
                position: ubicacion,
                title: "Su Ubicación",
                draggable: true
            });

            //Ubica el objeto marcador en el mapa
            marcador.setMap(map);

            //Configura el listener para el arrastre del marcador
            marcador.addListener("dragend", function (event) {

                //El Geocodificador convierte de coordenadas a dirección
                geocodificar(event.latLng);

            });

            //Inicializa el objeto para autocompletado en el campo de texto para la dirección
            autocompletar = new google.maps.places.Autocomplete((
                    document.getElementById("direccion")), {});
            lugares = new google.maps.places.PlacesService(map);

            //Configura el listener para cuando se elige la dirección
            autocompletar.addListener("place_changed", function () {
                var lugar = autocompletar.getPlace();
                if (lugar.geometry) {
                    //Si hay resultado, ubica el marcador en la dirección elegida
                    marcador.setPosition(lugar.geometry.location);
                    dir = document.getElementById("direccion").value;
                    infoWindow.setContent([
                        '<b>Usted esta aquí:</b><br>',
                        dir
                    ].join(''));
                    infoWindow.open(map, marcador);
                    map.panTo(lugar.geometry.location);
                    map.setZoom(16);

                    separador = ",",
                            document.getElementById("Latitud").value = lugar.geometry.location;
                    var ubica = document.getElementById("Latitud").value;
                    ubica = ubica.replace(/[\(\)]/g, "");
                    var separador = ",";
                    var arregloDeSubCadenas = ubica.split(separador);
                    var latitud_aux = arregloDeSubCadenas[0];
                    var longitud_aux = arregloDeSubCadenas[1];
                    document.getElementById("Latitud").value = latitud_aux;
                    document.getElementById("Longitud").value = longitud_aux;
                } else {
                    document.getElementById("direccion").placeholder = "Escriba una dirección";
                }
            });
        }

        function geocodificar(latLng) {
            geocoder.geocode({"latLng": latLng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        dir = results[0].formatted_address;
                        infoWindow.setContent([
                            '<b>Usted esta aquí:</b><br>',
                            dir
                        ].join(''));
                        infoWindow.open(map, marcador);
                        document.getElementById("direccion").value = dir;
                        separador = ",",
                                document.getElementById("Latitud").value = latLng;
                        var ubica = document.getElementById("Latitud").value;
                        ubica = ubica.replace(/[\(\)]/g, "");
                        var separador = ",";
                        var arregloDeSubCadenas = ubica.split(separador);
                        var latitud_aux = arregloDeSubCadenas[0];
                        var longitud_aux = arregloDeSubCadenas[1];
                        document.getElementById("Latitud").value = latitud_aux;
                        document.getElementById("Longitud").value = longitud_aux;

                    } else {
                        dir = "<p>No se ha podido obtener ninguna dirección en esas coordenadas.</p>";
                        alert(dir);
                    }
                } else {
                    dir = "<p>El Servicio de Codificación Geográfica ha fallado con el siguiente error: " + status + ".</p>";
                    alert(dir);
                }
            });
        }
    </script>    
    <label>Lugar: </label> <?php echo $lugar; ?>
    <form action="<?php echo base_url(); ?>index.php/comisiones/addmapa_api" method="post" accept-charset="utf-8" autocomplete="on" class="form-inline" id="form_mapa">
        <input name="lugar" id="lugar" type="hidden" value="<?php echo $lugar; ?>" />
        <input name="destino" id="destino" type="hidden" value="<?php echo $destino; ?>" />
        <input name="id_datos" id="id_datos" type="hidden" value="<?php echo $id_datos; ?>" />
        <input name="id_lugar" id="id_datos" type="hidden" value="<?php echo $id_lugar; ?>" />
        <input name="ruta" id="ruta" type="hidden" value="<?php echo base_url(); ?>index.php/comisiones/deletemapa/<?php echo $destino; ?>" />
        <div class="form-group">
            <label for="direccion">Dirección: </label>
            <input class="form-control" type="text" id="direccion" size="50" name="direccion" required="" value="<?php echo @$lugares[0]->direccion; ?>" />
        </div>
        <div class="form-group">
            <label for="Latitud">Latitud: </label>
            <input class="form-control" type="text" id="Latitud" size="30" name="latitud" readonly="" value="<?php echo @$lugares[0]->latitud; ?>" />
        </div>
        <div class="form-group">
            <label for="Latitud">Longitud: </label>
            <input class="form-control" type="text" id="Longitud" size="30" name="longitud" readonly="" value="<?php echo @$lugares[0]->longitud; ?>" />
        </div>
        <?php if($estado == 0){?>
            <input name="accion" id="accion" type="hidden" value="0" />
            <button type="button" name="crear" id="crear" class="btn btn-primary" onclick="form_mapa.submit()">Guardar ubicación</button>
        <?php }else{ ?>
            <input name="accion" id="accion" type="hidden" value="1" />
            <button type="button" name="actualizar" id="actualizar" class="btn btn-primary" onclick="form_mapa.submit()">Actualizar ubicación</button>
            <button type="button" name="eliminar" id="eliminar" class="btn btn-danger" onclick="clickbutton(<?php echo $id_lugar; ?>, '<?php echo $id_datos; ?>')">Eliminar ubicación</button>
        <?php } ?>
        <a href="javascript:window.history.back();" class="btn btn-default">Volver</a>
    </form>
    
    <br />
    <div id="map" style="width: 100%; height: 450px"></div>
    <a href="<?php echo base_url(); ?>index.php/comisiones/mapa2" data-remote="<?php echo base_url(); ?>index.php/comisiones/mapa2"  data-toggle="modal" data-target="#myModal">Enlace_1</a>
    <!-- Modal -->
    <div class="modal fade" data-refresh="true" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:51%;">
            <div class="modal-content">

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

<?php
} else {
    echo redirect(base_url("index.php/login/iniciar_sesion"));
}
?>