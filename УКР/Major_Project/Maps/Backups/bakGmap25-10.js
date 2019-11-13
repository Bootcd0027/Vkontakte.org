  var geocoder;
  var india = new google.maps.LatLng(17.466929481348622,78.5242490234375);
  var directionDisplay;
  var directionsService = new google.maps.DirectionsService();
  var map;
  var markersArray = [];
  var editable = 1;
  var waypts = [];
  var waywr=1;
  var upImage = new google.maps.MarkerImage('Icons/up64.png',
		  // This marker is 20 pixels wide by 32 pixels tall.
		  new google.maps.Size(64, 64),
		  // The origin for this image is 0,0.
		  new google.maps.Point(0,0),
		  // The anchor for this image is the base of the flagpole at 0,32.
		  new google.maps.Point(32, 64));
  var downImage = new google.maps.MarkerImage('Icons/down64.png',
		  // This marker is 20 pixels wide by 32 pixels tall.
		  new google.maps.Size(64, 64),
		  // The origin for this image is 0,0.
		  new google.maps.Point(0,0),
		  // The anchor for this image is the base of the flagpole at 0,32.
		  new google.maps.Point(32, 64));
  var wayImage = new google.maps.MarkerImage('Icons/way32.png',
		  // This marker is 20 pixels wide by 32 pixels tall.
		  new google.maps.Size(32, 32),
		  // The origin for this image is 0,0.
		  new google.maps.Point(0,0),
		  // The anchor for this image is the base of the flagpole at 0,32.
		  new google.maps.Point(16, 32));

  function RefreshControl(refreshControlDiv, map) {

	  // Set CSS styles for the DIV containing the control
	  // Setting padding to 5 px will offset the control
	  // from the edge of the map
	  refreshControlDiv.style.padding = '5px';

	  // Set CSS for the control border
	  var refreshControlUI = document.createElement('DIV');
	  refreshControlUI.style.backgroundColor = '#9CED98';
	  refreshControlUI.style.borderStyle = 'solid';
	  refreshControlUI.style.borderWidth = '2px';
	  refreshControlUI.style.cursor = 'pointer';
	  refreshControlUI.style.color = 'black';
	  refreshControlUI.style.textAlign = 'center';
	  refreshControlUI.title = 'Click to reload the map';
	  refreshControlDiv.appendChild(refreshControlUI);

	  // Set CSS for the control interior
	  var refreshControlText = document.createElement('DIV');
	  refreshControlText.style.fontFamily = 'Arial,sans-serif';
	  refreshControlText.style.fontSize = '12px';
	  refreshControlText.style.paddingLeft = '4px';
	  refreshControlText.style.paddingRight = '4px';
	  refreshControlText.innerHTML = '<b ">Reload</b>';
	  refreshControlUI.appendChild(refreshControlText);

	  // Setup the click event listeners: simply set the map to Chicago
	  google.maps.event.addDomListener(refreshControlUI, 'click', function() {
			  waywr = 1;
			  editable = 1;
			  waypts = [];
			  markersArray.length=0;
			  initialize();
			  getNames(null);
			  });
  }

  function FinalControl(finalControlDiv, map) {

	  // Set CSS styles for the DIV containing the control
	  // Setting padding to 5 px will offset the control
	  // from the edge of the map
	  finalControlDiv.style.padding = '5px';

	  // Set CSS for the control border
	  var finalControlUI = document.createElement('DIV');
	  finalControlUI.style.backgroundColor = 'pink';
	  finalControlUI.style.borderStyle = 'solid';
	  finalControlUI.style.borderWidth = '2px';
	  finalControlUI.style.color = 'black';
	  finalControlUI.style.cursor = 'pointer';
	  finalControlUI.style.textAlign = 'center';
	  finalControlUI.title = 'Click to Finalize the Selection';
	  finalControlDiv.appendChild(finalControlUI);

	  // Set CSS for the control interior
	  var finalControlText = document.createElement('DIV');
	  finalControlText.style.fontFamily = 'Arial,sans-serif';
	  finalControlText.style.fontSize = '12px';
	  finalControlText.style.paddingLeft = '4px';
	  finalControlText.style.paddingRight = '4px';
	  finalControlText.innerHTML = '<b>Finalize</b>';
	  finalControlUI.appendChild(finalControlText);

	  // Setup the click event listeners: simply set the map to Chicago
	  google.maps.event.addDomListener(finalControlUI, 'click', function() {
			  editable=0;
			  waywr=0;
			  deleteOverlays();
			  });
  }

  var contentString='<div style="padding-left:50px;padding-right:50px;color:black" >Select your start location. Please check out the <a href=#guide style="color:red">Map guide</a><br />Clicking on the map will place the marker.</div>';
  var infowindow = new google.maps.InfoWindow({
	content: contentString,
	position: india
	});

  function initialize() {
    geocoder = new google.maps.Geocoder();
    directionsDisplay = new google.maps.DirectionsRenderer();
    var mapOptions = {
      zoom: 5,
      center: india,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
    directionsDisplay.setMap(map);
    infowindow.open(map);
    setTimeout("infowindow.close()",5000)

	//Finalize Buttom-----------------
    var finalControlDiv = document.createElement('DIV');
    var finalControl = new FinalControl(finalControlDiv, map);

    finalControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(finalControlDiv);
    	//--------------------------------

	//Refresh Button------------------
    var refreshControlDiv = document.createElement('DIV');
    var refreshControl = new RefreshControl(refreshControlDiv, map);

    refreshControlDiv.index = 2;
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(refreshControlDiv);
	//--------------------------------

    google.maps.event.addListener(map, 'click', function(event) {
      addMarker(event.latLng);
    });
  }


  function placeBothMarkers()
  {
	//Initializing----------------------
	waywr = 1;
	waypts = [];
	deleteOverlays();
	editable=1;
	markersArray.length=0;
	//Done Init-------------------------
	var src = document.getElementById("src").value;
	var dest = document.getElementById("dest").value;
	var srcLatLng, destLatLng;
	geocoder.geocode( { 'address': src}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) 
			{
				srcLatLng=results[0].geometry.location;
				addMarker(srcLatLng);
			}
			else
			{
				alert("No such Source location exists in the World!!!!");
			}
	});
	geocoder.geocode( { 'address': dest}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) 
			{
				destLatLng=results[0].geometry.location;
				addMarker(destLatLng);
			}
			else
			{
				alert("No such Destination location exists in the World!!!!");
			}
	});
  }
  function addMarker(location) {
	  if (markersArray.length == 0 && editable)
	  {
    		marker = new google.maps.Marker({
      		position: location,
      		map: map,
		icon: upImage,
		draggable: true,
		title: 'Source',
		zIndex: -1
    		});
    		markersArray.push(marker);
	  }
	  else if (markersArray.length == 1 && editable)
	  {
    		marker = new google.maps.Marker({
      		position: location,
      		map: map,
		icon: downImage,
		draggable: true,
		title: 'Source',
		title: 'Destination',
		zIndex: -2
    		});
    		markersArray.push(marker);
		//Direction mapping
		mapMarkers(markersArray[0].getPosition(),markersArray[1].getPosition());
	  }


	google.maps.event.addListener(markersArray[0], 'dragend', function() {
		waywr = 0;
		mapMarkers(markersArray[0].getPosition(),markersArray[1].getPosition());
		});

	google.maps.event.addListener(markersArray[1], 'dragend', function() {
		waywr = 0;
		mapMarkers(markersArray[0].getPosition(),markersArray[1].getPosition());
		});
  }

	function check()
	{
		if(markersArray.length!=0) 
		{ 
			alert('No Path between src and dest');
		}
	}

	function mapMarkers(start, end)
	{
		var p1 = document.getElementById("wp1").value;
		var p2 = document.getElementById("wp2").value;
		var p3 = document.getElementById("wp3").value;
		if(p1!='' && waywr == 1)
		{
			waypts.push({location:p1,stopover:true});
		}
		if(p2!='' && waywr==1)
		{
			waypts.push({location:p2,stopover:true});
		}
		if(p3!='' && waywr==1)
		{
			waypts.push({location:p3,stopover:true});
		}
		var request = {
			origin:start, 
			destination:end,
			waypoints: waypts,
		        optimizeWaypoints: true,
			travelMode: google.maps.DirectionsTravelMode.DRIVING
			};
		directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
				getNames(response);
				}
			});
	//	setTimeout("check()",4000);
	}

function getNames(directionResult) {
	var start = document.getElementById('Start');
	var end = document.getElementById('End');
	var dist = document.getElementById('Dist');
	var summaryPanel = document.getElementById("directions_panel");
	if(directionResult==null)
	{
		start.innerHTML = '';
		end.innerHTML = '';
		dist.innerHTML = '';
		summaryPanel.innerHTML = '';
		return;
	}
	var route = directionResult.routes[0];
	var i=1;
	var distance=route.legs[0].distance.value;
	summaryPanel.innerHTML = '';
	if(route.legs.length>1)
	{
		distance=0;
		// For each route, display summary information.
		for (i = 0; i < route.legs.length ; i++) 
		{
			var routeSegment = i + 1;
			summaryPanel.innerHTML += "<b>Route Segment: " + routeSegment + "</b><br />";
			summaryPanel.innerHTML += route.legs[i].start_address + " <b style=\"color:pink\">to</b> ";
			summaryPanel.innerHTML += route.legs[i].end_address + "<br />";
			summaryPanel.innerHTML += route.legs[i].distance.text + "<br />";
			distance += route.legs[i].distance.value;
			if(i<route.legs.length-1)
			{
				summaryPanel.innerHTML += "<br />";
			}
		}
	}
	i--;
	start.innerHTML = directionResult.routes[0].legs[0].start_address;
	end.innerHTML = directionResult.routes[0].legs[i].end_address;
	dist.innerHTML = distance/1000 + 'Km';
}

  // Deletes all markers in the array by removing references to them
  function deleteOverlays() {
    if (markersArray) {
      for (i in markersArray) {
        markersArray[i].setMap(null);
      }
      markersArray.length = 0;
    }
  }

function showOverlays() 
{
	if (markersArray) 
	{
		for (i in markersArray) 
		{
			markersArray[i].setMap(map);
		}
	}
}
google.maps.event.addDomListener(window, 'load', initialize);
