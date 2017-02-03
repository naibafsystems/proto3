         
<style>
    body { padding: 10px; background-color:#CCC }
    #map-container { height: 450px }
</style>



<p><a href="#mapmodals" role="button" data-toggle="modal"><img src="04_maps.png" width="64" height="64" alt="map Venice" title="click to open Map"></a></p>

Dirección: <input type="text" id="direccion" size="60"/>
Latitud: <input type="text" id="Latitud" size="30"/>
Longitud: <input type="text" id="Longitud" size="30"/>
<div id="map" style="width: 100%; height: 450px"></div>
<!-- Modal -->
<div class="modal fade" id="mapmodals">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Mapa de ubicación</h4>
            </div>
            <div class="modal-body">
                <div id="map-container"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div><!-- /container -->     





<script src="<?php echo base_url(); ?>public/js/jquery-1.12.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>

<script>
    var var_map;
    var var_location = {lat: 4.647268, lng: -74.095318};

    function map_init() {

        var var_mapoptions = {
            center: var_location,
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            panControl: true,
            rotateControl: true,
            streetViewControl: true
        };
        var_map = new google.maps.Map(document.getElementById("map-container"),
                var_mapoptions);

        var contentString =
                '<div id="mapInfo">' +
                '<p><strong>Peggy Guggenheim Collection</strong><br><br>' +
                'Dorsoduro, 701-704<br>' +
                '30123<br>Venezia<br>' +
                'P: (+39) 041 240 5411</p>' +
                '<a href="http://www.guggenheim.org/venice" target="_blank">Plan your visit</a>' +
                '</div>';

        var var_infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        var var_marker = new google.maps.Marker({
            position: var_location,
            map: var_map,
            title: "Click for information about the Guggenheim museum in Venice",
            maxWidth: 200,
            maxHeight: 200
        });

        google.maps.event.addListener(var_marker, 'click', function () {
            var_infowindow.open(var_map, var_marker);
        });
    }

    google.maps.event.addDomListener(window, 'load', map_init);
//$('#mapmodals').modal('show');
//start of modal google map
    $('#mapmodals').on('shown.bs.modal', function () {
        google.maps.event.trigger(var_map, "resize");
        var_map.setCenter(var_location);

    });

</script>
