  var geocoder;
  var india = new google.maps.LatLng(17.466929481348622,78.5242490234375);
  var directionDisplay;
  var directionsService = new google.maps.DirectionsService();
  var map;
  var markersArray = [];
  var wayMarkers = [];
  var editable = 1;
  var waypts = [];
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
  var wayImage = new google.maps.MarkerImage('Icons/way64.png',
		  // This marker is 20 pixels wide by 32 pixels tall.
		  new google.maps.Size(64, 64),
		  // The origin for this image is 0,0.
		  new google.maps.Point(0,0),
		  // The anchor for this image is the base of the flagpole at 0,32.
		  new google.maps.Point(32, 64));

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
			  editable = 1;
			  waypts = [];
			  wayMarkers = [];
			  markersArray = [];
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
			  deleteOverlays();
			  });
  }

  var contentString='<div style="padding-left:50px;padding-right:50px;color:black" >Select your start location. Please check out the <span style=\"cursor:pointer;color:red\"onclick=\"$(\'#extruderLeft\').openMbExtruder(true);$(\'#extruderLeft\').openPanels()\">Map Guide</span><br />Clicking on the map will place the marker.</div>';
  var infowindow = new google.maps.InfoWindow({
	content: contentString,
	position: india
	});

  function initialize(flag) {
    geocoder = new google.maps.Geocoder();
    directionsDisplay = new google.maps.DirectionsRenderer();
    var mapOptions = {
      zoom: 5,
      center: india,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
    directionsDisplay.setMap(map);
	if(flag!=1)
	{
		infowindow.open(map);
	}
//    setTimeout("infowindow.close()",5000)

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
		infowindow.close();
		addMarker(event.latLng,editable);
    });
  }

function GeoCode(name,isSrcDest)
{
	var nameLatLng;
	geocoder.geocode( { 'address': name}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) 
			{
				nameLatLng=results[0].geometry.location;
				addMarker(nameLatLng,isSrcDest,name);
			}
			else
			{
				alert("Could not locate the position of \""+name+"\" due to "+status);
			}
	});
}
  function reverseGeoCode(loc,sFlag)
{
	geocoder.geocode({'latLng': loc}, function(results, status) 
		{
			if (status == google.maps.GeocoderStatus.OK) 
			{
				var bestIndex=0,minvar=1000;
				if(results[0])
				{
					for(var i=0;i<results.length ;i++)
					{
						var newLatLng = results[i].geometry.location;
						var temp = Math.abs(newLatLng.lat()-loc.lat()) + Math.abs(newLatLng.lng() - loc.lng());
						if(temp<minvar)
						{
							bestIndex = i;
							minvar = temp;
						}
					}
					name= results[bestIndex].formatted_address;
					if(sFlag==undefined || sFlag==null)
						waypts.push({location:name,stopover:true});
					else
						waypts.splice(sFlag,1,{location:name,stopover:true});
					mapMarkers(markersArray[0].getPosition(),markersArray[1].getPosition());
				}
				else
					name=null;
			} 
			else 
			{
				alert("Geocoder failed due to: " + status);
				name=null;
			}
		});
  }
  function placeBothMarkers()
  {
	//Initializing----------------------
	waypts = [];
	deleteOverlays();
	editable=1;
	markersArray.length=0;
	initialize(1);
	//Done Init-------------------------
	//Getting divs'---------------------------
	var srcB = document.getElementById("src");
	var wap1 = document.getElementById("wp1");
	var wap2 = document.getElementById("wp2");
	var wap3 = document.getElementById("wp3");
	var destB = document.getElementById("dest");
	//Got divs'-------------------------------

	//Taking Value
	var src = srcB.value;
	var p1 = wap1.value;
	var p2 = wap2.value;
	var p3 = wap3.value;
	var dest = destB.value;
	//Done Taking Value

	//Setting to zero
	srcB.value='';
	wap1.value='';
	wap2.value='';
	wap3.value='';
	destB.value='';
	//Done Setting to zero

	//GeoCoding the values
	GeoCode(src,1);
	pausecomp(100);
	GeoCode(dest,1);
	pausecomp(100);
	if(p1!='')
	{
		GeoCode(p1,0);
		pausecomp(100);
	}
	if(p2!='')
	{
		GeoCode(p2,0);
		pausecomp(100);
	}
	if(p3!='')
	{
		GeoCode(p3,0);
		pausecomp(100);
	}
	//Done GeoCoding the Values
  }
  //location is the latlng isSrcDest specified whether its src/dest or waypoint sFlag means if marker is added sue to dragging after placing
  function addMarker(location,isSrcDest,name,sFlag) {
	  if(!isSrcDest && (waypts.length<3 || (sFlag!=null && sFlag!=undefined)))
	  {
    		marker = new google.maps.Marker({
      		position: location,
      		map: map,
		icon: wayImage,
		draggable: true,
		title: 'Waypoint',
    		});
		if(sFlag==undefined || sFlag==null || sFlag=='')
			wayMarkers.push(marker);
		else
			wayMarkers.splice(sFlag,0,marker);
		if(name==undefined || name==null || name=='')
		{
			reverseGeoCode(location,sFlag);
		}
		else
		{
			waypts.push({location:name,stopover:true});				
		}
		if(markersArray.length==2)			
			mapMarkers(markersArray[0].getPosition(),markersArray[1].getPosition());
	  }
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
		title: 'Destination',
		zIndex: -2
    		});
		editable=0;
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

	google.maps.event.addListener(wayMarkers[0], 'dragend', function() {
		var temp = wayMarkers[0].getPosition();
		wayMarkers[0].setMap(null);
		wayMarkers.splice(0,1);
		addMarker(temp,0,null,0)
		});

	google.maps.event.addListener(wayMarkers[1], 'dragend', function() {
		var temp = wayMarkers[1].getPosition();
		wayMarkers[1].setMap(null);
		wayMarkers.splice(1,1);
		addMarker(temp,0,null,1)
		});

	google.maps.event.addListener(wayMarkers[2], 'dragend', function() {
		var temp = wayMarkers[2].getPosition();
		wayMarkers[2].setMap(null);
		wayMarkers.splice(2,1);
		addMarker(temp,0,null,2)
		});
  }

	function mapMarkers(start, end)
	{
		//Creating request variable
		var request = {
			origin:start, 
			destination:end,
			waypoints: waypts,
			travelMode: google.maps.DirectionsTravelMode.DRIVING
			};
		//Requesting Path and then going to get names
		directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
				getNames(response);
				}
			});
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
	if (wayMarkers) {
		for (i in wayMarkers) {
			wayMarkers[i].setMap(null);
		}
		wayMarkers.length = 0;
	}
	if (markersArray) {
		for (i in markersArray) {
			markersArray[i].setMap(null);
		}
		markersArray.length = 0;
	}
}

function pausecomp(millis) 
{
	var date = new Date();
	var curDate = null;

	do { curDate = new Date(); } 
	while(curDate-date < millis);
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
