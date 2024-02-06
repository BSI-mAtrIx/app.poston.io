<?php include(APPPATH.'modules/n_mashkar/include/location_modal.php');



if(!empty($social_analytics_codes['mashkor'])){
    $social_analytics_codes['mashkor'] = json_decode($social_analytics_codes['mashkor'], true);
    $api_google = $social_analytics_codes['mashkor']['config']['google_api'];
}
?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $api_google; ?>&callback=initMap"></script>

<script>
    var map;
    var marker;
    var initialPosition;
    var markers = [];

    function create_map(){
        map = new google.maps.Map(document.getElementById('map'), {
            center: initialPosition,
            zoom: 15
        });

        addMarker(initialPosition);

        google.maps.event.addListener(map, 'click', function(event) {
            deleteMarkers();
            addMarker(event.latLng);
        });

        // Add event listener for street input change
        document.getElementById('mash_landmark').addEventListener('change', function() {
            //change_location();
        });
        document.getElementById('mash_block').addEventListener('change', function() {
            //change_location();
        });
    }

    function change_location(){
        var geocoder = new google.maps.Geocoder();
        var c_selectedValue = $('#country').val();
        var c_city = $('#city').val();
        var c_country = $('#country option[value='+c_selectedValue+']').data('country');

        geocoder.geocode({ 'address': c_city+', '+c_country }, function(results, status) {
            if (status == 'OK') {
                var position = results[0].geometry.location;
                map.setCenter(position);
                deleteMarkers();
                addMarker(position);
                document.getElementById('lat').value = position.lat();
                document.getElementById('lng').value = position.lng();
            }
        });
    }

    function addMarker(location) {
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true
        });
        markers.push(marker);

        google.maps.event.addListener(marker, 'dragend', function (event) {
            document.getElementById('lat').value = this.getPosition().lat();
            document.getElementById('lng').value = this.getPosition().lng();
        });

        // Store lat and lng values
        document.getElementById('lat').value = location.lat();
        document.getElementById('lng').value = location.lng();
    }

    function deleteMarkers() {
        clearMarkers();
        markers = [];
    }

    function clearMarkers() {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
    }

    function initMap() {
        var geocoder = new google.maps.Geocoder();

        var lat = document.getElementById('lat').value;
        var lng = document.getElementById('lng').value;

        if(lat && lng) {
            initialPosition = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
            create_map();
        } else {
            var c_selectedValue = $('#country').val();
            var c_city = $('#city').val();
            var c_country = $('#country option[value='+c_selectedValue+']').data('country');

            geocoder.geocode( { 'address': c_city+', '+c_country}, function(results, status) {
                if (status == 'OK') {
                    initialPosition = results[0].geometry.location;
                    create_map();
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });

        }


    }



    $("document").ready(function () {

        function open_modal_location(){
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: '#Mashkor_Modal_Location'
                },
                preloader: false,
                modal: true
            });

            initMap();
        }

        $(document).on('change', '#country', function (e) {
            document.getElementById('lat').value = '';
            document.getElementById('lng').value = '';
        });

        $(document).on('change', '#city', function (e) {
            document.getElementById('lat').value = '';
            document.getElementById('lng').value = '';
        });


        $(document).on('change', 'input:radio[name ="shipping"]', function (e) {
            $dm_selected = $("input:radio[name ='shipping']:checked");
            mashkor = $dm_selected.attr('data-type-mashkor');

            if(mashkor != undefined){
                open_modal_location();
            }
        });

        $(document).on('click', '#btn_mashkor_modal', function (e) {
            e.preventDefault();
            open_modal_location();
        });

        $(document).on('click', '.save_mashkor_details', function (e) {
            apply_store_delivery_method();
            $.magnificPopup.close();
        });



    });



</script>

