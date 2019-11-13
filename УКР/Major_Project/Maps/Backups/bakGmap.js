  var geocoder;
  var india = new google.maps.LatLng(17.466929481348622,78.5242490234375);
  var directionDisplay;
  var directionsService = new google.maps.DirectionsService();
  var map;
  var markersArray = [];
  var editable = 1;

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
	  refreshControlUI.style.textAlign = 'center';
	  refreshControlUI.title = 'Click to reload the map';
	  refreshControlDiv.appendChild(refreshControlUI);

	  // Set CSS for the control interior
	  var refreshControlText = document.createElement('DIV');
	  refreshControlText.style.fontFamily = 'Arial,sans-serif';
	  refreshControlText.style.fontSize = '12px';
	  refreshControlText.style.paddingLeft = '4px';
	  refreshControlText.style.paddingRight = '4px';
	  refreshControlText.innerHTML = '<b>Reload</b>';
	  refreshControlUI.appendChild(refreshControlText);

	  // Setup the click event listeners: simply set the map to Chicago
	  google.maps.event.addDomListener(refreshControlUI, 'click', function() {
			  editable=1;
			  markersArray.length=0;
			  initialize()
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
			  deleteOverlays();
			  });
  }

  var contentString='<div style="padding-left:50px;padding-right:50px" >Select your start location. Please check out the <a href=guide.html target=_blank >Map guide</a><br />Clicking on the map will place the marker.</div>';
  var infowindow = new google.maps.InfoWindow({
	content: contentString,
	position: india
	});

  function initialize() {
    geocoder = new google.maps.Geocoder();
    directionsDisplay = new google.maps.DirectionsRenderer({draggable: true});
    var mapOptions = {
      zoom: 5,
      center: india,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
    directionsDisplay.setMap(map);
    infowindow.open(map);

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
	  deleteOverlays();
	editable=1;
	markersArray.length=0;
	var src = document.getElementById("src").value;
	var dest = document.getElementById("dest").value;
	var srcLatLng;
	var destLatLng;
	geocoder.geocode( { 'address': src}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) 
			{
				srcLatLng=results[0].geometry.location;
				addMarker(srcLatLng);
//				alert("Answer src = "+srcLatLng)
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
//				alert("Answer dest = "+destLatLng)
			}
			else 
			{
				alert("No such Source location exists in the World!!!!");
			}
	});
  }
  function addMarker(location) {
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
	  if (markersArray.length == 0 && editable)
	  {
    		marker = new google.maps.Marker({
      		position: location,
      		map: map,
		icon: upImage,
		title: 'Source',
		draggable: true,
		bounce: true,
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
		title: 'Destination',
		draggable: true,
		bounce: true,
		zIndex: -2
    		});
    		markersArray.push(marker);
		//Direction mapping
		mapMarkers(markersArray[0].getPosition(),markersArray[1].getPosition());
	  }


	google.maps.event.addListener(markersArray[0], 'dragend', function() {
		mapMarkers(markersArray[0].getPosition(),markersArray[1].getPosition());
		});

	google.maps.event.addListener(markersArray[1], 'dragend', function() {
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
		var request = {
			origin:start, 
			destination:end,
			travelMode: google.maps.DirectionsTravelMode.DRIVING
			};
		directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
				deleteOverlays();
				editable=0;
				}
			});
		setTimeout("check()",4000);
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
