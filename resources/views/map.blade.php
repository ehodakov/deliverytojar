@extends('layouts.main')

@section('content')
    <body onload="initialize()">
    <input id="order-input" class="controls" type="text" placeholder="Местоположение заказа">
    <div id="map_canvas"></div>
    </body>

    <script type="text/javascript">
        function initialize() {
            marker = null;
            var mapOptions = {
                center: new google.maps.LatLng(37.286172, -121.80929),
                zoom: 8,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById("map_canvas"),
                    mapOptions);

            // Create the search box and link it to the UI element.
            var input = document.getElementById('order-input');
            // var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

            $('#order-input').keydown(function(e) {
                if (e.which == 13){
                    var order_id = parseInt($('#order-input').val());
                    if (order_id > 0) {
                        $.get('/order/' + order_id, function(data) {
                            if (data['result'] == 'ok') {
                                if (marker != null) {
                                    marker.setMap(null);
                                }

                                var point = new google.maps.LatLng(parseFloat(data['latitude']), parseFloat(data['longitude']));
                                marker = new google.maps.Marker({
                                    //icon: myicon,
                                    position: point,
                                    map: map,
                                    title: 'Заказ №'+order_id
                                });

                                var infowindow = new google.maps.InfoWindow({
                                    content: data['location']
                                });
                                google.maps.event.addListener(marker, 'click', function() {
                                    infowindow.open(map, marker);
                                });

                                map.setCenter({
                                    lat: parseFloat(data['latitude']),
                                    lng: parseFloat(data['longitude'])
                                });
                            } else {
                                alert('Ошибка');
                            }
                            console.log(data);
                        }).fail(function() {
                            alert('Заказ не найден');
                        });
                    }
                }
            });

        }
    </script>
@endsection
