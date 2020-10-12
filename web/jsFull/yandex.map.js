//карты
var i=0;  
if (($(".container_map").length > 0)){
$.getJSON( "/admin/settings/getmaps", function( data ) {
	$.each( data, function( key, val ) {
		$("<div id='maps_"+i+"' class='maps'><div class='form-inline form-group'><label>Адрес точки карты: </label> <div class='form-inline form_map'><input id='adress_"+i+"' class = 'form-control' type='text' name='map["+i+"][adress]' value='"+val.adress+"' /><label type='submit' class='btn btn-default search_map'>поиск</label><label type='submi' class='btn btn-default delete_map'>удалить</label><input class='geo' type='hidden' name='map["+i+"][coords]' value='"+val.coords+"' /><input class='idi' type='hidden' name='map["+i+"][id]' value='"+val.id+"' /></div></div><div class='map' id='map_"+i+"' style='width: 100%; height: 300px;'></div></div>").appendTo( $( ".container_map" ) );
		createMap(i, val.coords);
		i++;
		
	});
	$('.delete_map').on('click', function(){
		var idMap = $(this).parents('.maps');
		$.post( "/admin/settings/deletemaps", { id: idMap.find('.idi').val()} );
		idMap.off();
		idMap.remove();
	});
});
} 
//generation maps
var myMap=[], myPlacemark=[];
$('#add_map').on("click", function(){  
	$("<div id='maps_"+i+"' class='maps'><div class='form-inline form-group'><label>Адрес точки карты: </label> <div class='form-inline form_map'><input id='adress_"+i+"' class = 'form-control' type='text' name='map["+i+"][adress]' value='' /><label type='submit' class='btn btn-default search_map'>поиск</label><label type='submit' class='btn btn-default delete_map'>удалить</label><input class='geo' type='hidden' name='map["+i+"][coords]' value='' /></div></div><div class='map' id='map_"+i+"' style='width: 100%; height: 300px;'></div></div>").appendTo( $( ".container_map" ) );
	createMap(i,null);
	i++;
	$('.delete_map').on('click', function(){
		var idMap = $(this).parents('.maps');
		idMap.off();
		idMap.remove();
	});
});
//Функции для создания карт
function createMap(id, coords){
	ymaps.ready(function(){
		var suggestView = new ymaps.SuggestView('adress_'+id);
		//myMap[id] = new ymaps.SuggestView('adress_'+i);
		if(coords!=null) {
			coords = coords.split(',');
			myMap[id] = new ymaps.Map("map_"+id, {
				center: coords,
				zoom: 13,
				behaviors: ['drag', 'scrollZoom']
			});
			createPlacemark(coords, id);
		}
		else {
			myMap[id] = new ymaps.Map("map_"+id, {
				center: [56.13385221230149,40.407199670206964],
				zoom: 10,
				behaviors: ['drag', 'scrollZoom']
			});	
		}
		
		myMap[id].controls.remove('searchControl');		
		myMap[id].events.add('click', function (e) {
			var coords = e.get('coords');
			$('#maps_'+id+' .geo').val(coords);
			createPlacemark(coords, id);
			getAddress(coords, id);
		});
		$('#maps_'+id+' .search_map').on("click", function(){
			var setCoords = ymaps.geocode($('#adress_'+id).val());
			setCoords.then(
				function (res) {
					var coords = res.geoObjects.get(0).geometry.getCoordinates();
					$('#maps_'+id+' .geo').val(coords);
					createPlacemark(coords, id);
				},
				function (err) {
					alert('Ошибка');
				}
			);
		});
	});
}
// Определяем адрес по координатам (обратное геокодирование)
function getAddress(coords, id) {
	//myPlacemark[id].properties.set('iconContent', 'поиск...');
	ymaps.geocode(coords).then(function (res) {
		var firstGeoObject = res.geoObjects.get(0);
		
		myPlacemark[id].properties
				.set({
					//iconContent: firstGeoObject.properties.get('name'),
					balloonContent: firstGeoObject.properties.get('text')
				});
		$('#adress_'+id).val(firstGeoObject.properties.get('text'));
	});
	 
}
// Создание метки
function createPlacemark(coords, id) {
	if (myPlacemark[id]) {
		myPlacemark[id].geometry.setCoordinates(coords);
	}
	// Если нет – создаем.
	else {
		myPlacemark[id] = new ymaps.Placemark(coords, {
							iconContent: ''
							}, {
							  preset: 'twirl#blueStretchyIcon',
							  draggable: true
							});		
		myMap[id].geoObjects.add(myPlacemark[id], id);
		// Слушаем событие окончания перетаскивания на метке.
		myPlacemark[id].events.add('dragend', function () {
			getAddress(myPlacemark[id].geometry.getCoordinates(), id);
		});
	}
	myMap[id].setCenter(coords, 15);
}
