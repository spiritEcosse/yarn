<script type="text/javascript">
  var directionDisplay;
  var directionsService = new google.maps.DirectionsService();  
  
  // Here you can customize the direction line color, weigth and opacity.
  var polylineOptionsActual = new google.maps.Polyline({
    strokeColor: '#585858',
    strokeOpacity: 0.7,
    strokeWeight: 4
    });
  
  function initialize() {
	// Place the coordinates of your store here.
    var latlng = new google.maps.LatLng(<?php echo $this->config->get('GALKAControl_latitude') ?>,<?php echo $this->config->get('GALKAControl_longitude') ?>);
	
    directionsDisplay = new google.maps.DirectionsRenderer();
	directionsDisplay = new google.maps.DirectionsRenderer(
	{
		suppressMarkers: true,
		polylineOptions: polylineOptionsActual
	});
	
    var myOptions = {
      // By changing this number you can define the resolution of the current view. Zoom level between 0 (the lowest zoom level, in which the entire world can be seen on one map) to 21+ (down to individual buildings) 
	  zoom: 17,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      mapTypeControl: true,
	  scrollwheel: false
    };
	
    var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
	
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("directionsPanel"));
	
	// Here you can change the path, size and pivot point of the marker on the map.
   	var image = new google.maps.MarkerImage('catalog/view/theme/GALKA/image/google_maps/marker.png',
        new google.maps.Size(45, 48),
        new google.maps.Point(0,0),
        new google.maps.Point(25,40)
    );
	
	// Here you can change the path, size and pivot point of the marker's shadow on the map.
    var shadow = new google.maps.MarkerImage('catalog/view/theme/GALKA/image/google_maps/shadow.png',
        new google.maps.Size(26, 10),
        new google.maps.Point(0,0),
        new google.maps.Point(10,4)
    );

	// Change the title of your store. People see this when they hover over your marker.
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        shadow: shadow,
        title:"GALKA Store",
        icon: image
    });

	// This function will make your marker bounce. When you click on it, it will toggle between bouncing and static. You can comment out if you don't whant your marker to bounce. 
	toggleBounce();
	google.maps.event.addListener(marker, 'click', toggleBounce);
	
	
	function toggleBounce() {
	
	  if (marker.getAnimation() != null) {
		marker.setAnimation(null);
	  } else {
		marker.setAnimation(google.maps.Animation.BOUNCE);
	  }
	}
  }
  
  // Change the coordinates below to those of your store. (should be the same as the coordinates above.
  function calcRoute() {
    var start = document.getElementById("routeStart").value;
    // Fill in the cordinates of your store. See readme file for help.
	var end = "<?php echo $this->config->get('GALKAControl_latitude') ?>,<?php echo $this->config->get('GALKAControl_longitude') ?>";
    var request = {
      origin:start,
      destination:end,
      travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      }
    });
  } 
  
  window.onload = initialize;
</script>