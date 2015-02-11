      var map;
      var marker;
      var lat;
      var lng;


      function initialize() {
        var mapOptions = {
          center: { lat: 51.79880222222, lng: 4.6839179722222},
          zoom: 15
        };
        map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);

        enableButton(false);
        function placeMarker(location) {
          if ( marker ) {
            marker.setPosition(location);
          } else {
            marker = new google.maps.Marker({
            position: location,
            map: map
          });
        enableButton(true)
        }
      }


      function enableButton(marker){
          if ( marker === true ) {
            document.getElementById("guessbutton").disabled = false;
          } else {
            document.getElementById("guessbutton").disabled = true;
          }
        }
        google.maps.event.addListener(map, 'click', function(event) {
        placeMarker(event.latLng);
        lat = marker.getPosition().lat();
        lng = marker.getPosition().lng();
        });
      }


      google.maps.event.addDomListener(window, 'load', initialize);


$(function() {

    // if #javascript-ajax-button exists
    if ($('#guessbutton').length !== 0) {

        $('#guessbutton').on('click', function(){
        id = $( "#photo" ).data("photoid");
            // send an ajax-request to this URL: current-server.com/songs/ajaxGetStats
            // "url" is defined in views/_templates/footer.php
            $.ajax(url + "/game/getLongLat/" + id)
                .done(function(result) {
                    console.log(lat);
                    console.log(lng);
                    // this will be executed if the ajax-call was successful
                    // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                    $('#javascript-ajax-result-box').html(result);
                    latlng = $.parseJSON(result);
                    photolocation = new google.maps.LatLng(latlng['lat'], latlng['lon']);
                    photomarker = new google.maps.Marker({
                        position: photolocation,
                        map: map
                    }); 
                     map.setCenter(photomarker.getPosition());

                    var guessCoordinates = [
                        new google.maps.LatLng(latlng['lat'], latlng['lon']),
                        new google.maps.LatLng(lat, lng)

                    ];
                    
                    var guessPath = new google.maps.Polyline({
                        path: guessCoordinates,
                        geodesic: true,
                        strokeColor: '#FF0000',
                        strokeOpacity: 1.0,
                        strokeWeight: 2
                    });
                    console.log(window.location.replace(url + "game/score/" + lat + '/' + lng + '/' + latlng['lat'] + '/' + latlng['lon'] + '/' + id));
                    guessPath.setMap(map);
                    google.maps.event.addDomListener(window, 'load', initialize);
                })
                .fail(function() {
                    // this will be executed if the ajax-call had failed
                })
                .always(function() {
                    // this will ALWAYS be executed, regardless if the ajax-call was success or not
                });
        });
    }
}); 