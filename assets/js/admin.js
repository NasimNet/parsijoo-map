jQuery(document).ready(function($) {

    var defLatlng = [31.879897, 54.317292];
    var map = L.map('leaflet').setView(defLatlng, 5);

    L.tileLayer('https://developers.parsijoo.ir/web-service/v1/map/?type=tile&x={x}&y={y}&z={z}&apikey=' + object_map.mapapi, {
        maxZoom: 20,
    }).addTo(map);

    var marker = L.marker(defLatlng, {
        draggable:true
    }).addTo(map);

    var zoomLev = '5';
    map.on("zoomend", function(){
        zoomLev = map.getZoom();
    });

    marker.on('drag', function (e) {
        marker.setLatLng(e.latlng);

        $('#latMAP').val( e.latlng.lat );
        $('#lngMAP').val( e.latlng.lng );
        $('#zoomMAP').val( zoomLev );

        var shortcode = '[parsijoo_map latlng="'+ e.latlng.lat + ',' + e.latlng.lng +'" zoom="'+ zoomLev +'" height="300"]';
        $('#parsijoo-shortcode').val( shortcode );
    });

    map.on('click', function (e) {
        marker.setLatLng(e.latlng);

        $('#latMAP').val( e.latlng.lat );
        $('#lngMAP').val( e.latlng.lng );
        $('#zoomMAP').val( zoomLev );

        var shortcode = '[parsijoo_map latlng="'+ e.latlng.lat + ',' + e.latlng.lng +'" zoom="'+ zoomLev +'" height="300"]';
        $('#parsijoo-shortcode').val( shortcode );
    });

    $('#parsijoo-shortcode, .input-example').focus(function() { $(this).select(); } );
});
