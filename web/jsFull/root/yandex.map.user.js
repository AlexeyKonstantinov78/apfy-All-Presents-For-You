var i=0;
var myMap=[], myPlacemark=[];
$.getJSON( "/site/getmaps", function( data ) {
	$.each( data, function( key, val ) {
		$("<div id='maps_"+i+"' class='maps form-group'><p>"+val.adress+"</p><div class='map' id='map_"+i+"' style='width: 100%; height: 300px;'></div></div>").appendTo( $( ".container_map" ) );
		createMap(i, val.coords);
		i++;
	});
});
function createMap(id, coords){
	ymaps.ready(function(){
		coords = coords.split(',');
		myMap[id] = new ymaps.Map("map_"+id, {
			center: coords,
			zoom: 13,
			behaviors: ['drag', 'scrollZoom']
		});
		myPlacemark[id] = new ymaps.Placemark(coords, {
			iconContent: ''
		}, {
		  preset: 'twirl#blueStretchyIcon',
		  draggable: true
		});
		myMap[id].geoObjects.add(myPlacemark[id], id);
		myMap[id].controls.remove('searchControl');
	})	
}