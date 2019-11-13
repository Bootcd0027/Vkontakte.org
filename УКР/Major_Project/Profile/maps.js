var directionDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
 
  function initialize() {
    directionsDisplay = new google.maps.DirectionsRenderer();
    var india = new google.maps.LatLng(17.466929481348622,78.5242490234375);
    var myOptions = {
      zoom:5,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      center: india
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    directionsDisplay.setMap(map);
  }
  
  function calcRoute(start,way1,way2,way3,end) {
	var waypts = [];
	if(way1!='')
		waypts.push({location:way1,stopover:true});
	if(way2!='')
		waypts.push({location:way2,stopover:true});
	if(way3!='')
		waypts.push({location:way3,stopover:true});
    var request = {
        origin:start,
	waypoints: waypts,
        destination:end,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      }
    });
  }
google.maps.event.addDomListener(window, 'load', initialize);
