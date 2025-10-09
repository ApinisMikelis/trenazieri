<?php if (!defined('WPINC')) die; ?>

<?php
	// Retrieve the repeater field data
	
	$coordinates_x = get_field('coordinates_x');
	$coordinates_y = get_field('coordinates_y');
?>


<div class="tre-map">
	<div class="inner">
		<div id="tre-map"></div>
	</div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/leaflet@1.9.3/dist/leaflet.min.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.min.js" crossorigin="anonymous"></script>


<script>

    jQuery(document).ready(function() {

        // Leaflet

        if(jQuery('.tre-map').length) {

            var map = L.map('tre-map').setView([56.928060400375635, 24.105844784670662, 15], 15);

            var mapContainerPos = document.getElementById('tre-map').getBoundingClientRect();

            var transform = L.DomUtil.setTransform;

            map.scrollWheelZoom.disable();

            var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            var mapMarkerIcon = L.icon({
                iconUrl: '<?php echo get_template_directory_uri();?>/assets/img/icon-map-marker-1.svg',
                iconSize:     [27, 27],
                iconAnchor:   [13, 13],
                popupAnchor:  [0, 0]
            });

            // Markers

            var pos1 = [<?php echo $coordinates_x;?>, <?php echo $coordinates_y;?>];

            window.marker1 = L.marker(pos1, {icon: mapMarkerIcon}).addTo(map);

            // Marker clusters

            window.markersAll = L.layerGroup([marker1]);

            var markersGroup = L.markerClusterGroup({
                spiderfyOnMaxZoom: false,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true,
                maxClusterRadius: 90,
                keepInView: true
            });

            markersGroup.addLayer(markersAll);

            map.addLayer(markersGroup);

        }

    });

</script>