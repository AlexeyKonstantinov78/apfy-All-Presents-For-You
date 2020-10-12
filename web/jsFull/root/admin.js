function urlRusLat(str) {
    str = str.toLowerCase(); // все в нижний регистр
		var cyr2latChars = {
				'а':'a','б':'b','в':'v','г':'g',
				'д':'d','е':'e','ё':'yo','ж':'zh','з':'z',
				'и':'i','й':'y','к':'k','л':'l',
				'м':'m','н':'n','о':'o','п':'p','р':'r',
				'с':'s','т':'t','у':'u','ф':'f',
				'х':'h','ц':'c','ч':'ch','ш':'sh','щ':'shch',
				'ъ':'','ы':'y','ь':'','э':'e','ю':'yu','я':'ya',
				' ':'-','/':'-','\\':'-','"':''
		};

    var newStr = new String();

    for (var i = 0; i < str.length; i++) {

		if(cyr2latChars[str[i]] !== undefined)
        newStr += cyr2latChars[str[i]];
		else newStr += str[i];

    }
    // ”дал¤ем повтор¤ющие знаки - »менно на них замен¤ютс¤ пробелы.
    // “ак же удал¤ем символы перевода строки, но это наверное уже лишнее
    return newStr.replace(/[-]{2,}/gim, '-').replace(/\n/gim, '').replace(/[^a-z0-9_-]/gim, '');
}
/*
$('.elements_group_cat').on('click', 'span.arrow_elements', function(){
    var first_element = $(this).parents('.elements_group');
    var action = $(this).data('move');
    var list_elements = $('.elements_group');
    var index_obj = list_elements.index(first_element);
    // for delete var id_first = first_element.data('key');
    var moveTo;
    var second_element;
    if (action == 'up') {
        moveTo = index_obj-1;
        action = 'before';
    } else {
        moveTo = index_obj+1;
        action = 'after';
    }
    second_element = $(list_elements).eq(moveTo);
    if(second_element.data('key') && moveTo>=0) {
        //alert('est');
        movingElements(first_element, second_element, action, '/root/shop/category/sortorder');
    }

});
/**/
// id = key node tree. m = up \ down
function movingElementsUniversal(first_element, second_element, action, url_sort){
    $.post( url_sort, { first_id: first_element, second_id: second_element, act: action}, function(data){
		/*if(action=='before'){
		 second_element.before(first_element);
		 } else {
		 second_element.after(first_element);
		 }*/
        //alert(data);
    });
}
function movenode(id,m){
	var Node = $("#tree").fancytree("getTree").getNodeByKey(id);
	var Parents = Node.getParent().getChildren();
	var countp = Parents.length;
	var NodeIndex = Node.getIndex();
	var action;
	var first_element = id;
	var second_element;
	
	if(m == 'up'){
		if(NodeIndex == 0 || countp < 2) return;
		Node.moveTo(Parents[NodeIndex-1],'before');
        action = 'before';
        second_element = Parents[NodeIndex].key;
	} else {
		if(NodeIndex == countp - 1 || countp < 2) return;
		Node.moveTo(Parents[NodeIndex+1],'after');
        action = 'after';
        second_element = Parents[NodeIndex].key;
	}
    movingElementsUniversal(first_element, second_element, action, '/root/shop/category/sort');
	
}

function deletenode() {
		var node = $("#tree").fancytree("getActiveNode");
		
		$.post('/root/shop/category/delete', {"id":node.key}, function(data) {
			if(data.message == true)
			{
				node.remove();
			}
		});
}

function deletenodeart() {
		var node = $("#tree").fancytree("getActiveNode");

		$.post('/root/articlecategory/delete', {"id":node.key}, function(data) {
			if(data.message == true)
			{
				node.remove();
			}
		});
}

function addnodeart(root){
	if(root)
		var Node = $("#tree").fancytree("getTree").getNodeByKey(root);
	else
		var Node = $("#tree").fancytree("getRootNode");

	$.post('/root/articlecategory/addchild', {"name": "Новая категория", "parent_id":root}, function(data) {
		Node.addChildren({
			title: "Новая категория",
			key: data.id,
			folder: true
		});
		Node.setExpanded(true);
	});

}

function addnode(root){
	if(root)
		var Node = $("#tree").fancytree("getTree").getNodeByKey(root);
	else
		var Node = $("#tree").fancytree("getRootNode");

	$.post('/root/shop/category/addchild', {"name": "Новая категория", "parent_id":root}, function(data) {
		Node.addChildren({
			title: "Новая категория",
			key: data.id,
			folder: true
		});
		Node.setExpanded(true);
	});

}


$(document).ready(function(){
	
	//модальные окна для быстрой правки
	/*
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
	*/

	/* bred bil
    var RootSeoUrl, BaseNameSeo;
	$(document).on('keyup', 'input.name_slug', function(){
        RootSeoUrl = $('input#hiddenSlugId').val();

		if(RootSeoUrl == 'undefined' && (BaseNameSeo !== $(this).val() || BaseNameSeo == 'undefined')){
            RootSeoUrl = '';
		}
		$('#seotags-slug').val(RootSeoUrl + urlRusLat($(this).val()));
	})
	//*/
    var BaseSeoUrl, hiddenRootUrl;
	$(document).on('keyup', 'input.name_slug', function(){
        BaseSeoUrl = $('input#BaseSeoUrl').val();
        hiddenRootUrl = $('input#hiddenRootUrl').val();
        if(!BaseSeoUrl) BaseSeoUrl = '';
        if(!hiddenRootUrl  || hiddenRootUrl=='katalog-') hiddenRootUrl = '';
        //if(BaseSeoUrl == 'undefined') hiddenRootUrl = '';
        //if(hiddenRootUrl == 'undefined') hiddenRootUrl = '';
        /* раскоментировать если нужно один раз вводить чпу
        if(BaseSeoUrl != '') {
            return false;
		}
		//*/
		$('#seotags-slug').val(hiddenRootUrl + urlRusLat($(this).val()));
	})

	$(function(){
		$(document).on('click', '.showModalButton', function(){
			if ($('#modal').data('bs.modal').isShown) {
				$('#modal').find('#modalContent')
						.load($(this).attr('value'));
				$('#modalHeader').find('h4').remove();
				$('<h4>' + $(this).attr('title') + '</h4>').appendTo('#modalHeader');
			} else {

				$('#modal').modal('show')
						.find('#modalContent')
						.load($(this).attr('value'));
				$('#modalHeader').find('h4').remove();
				$('<h4>' + $(this).attr('title') + '</h4>').appendTo('#modalHeader');
			}

		});
	});



	$('#model-form').on('beforeSubmit', function () {  return false; })

	//добавление и удаление атрибутов
	$(function(){
		var m=$('#attr .form-inline.form-group:last').data('mas');
		var last_id = $("#attr .del_attr:last").data('del');
		if(!m){
			m=0;
			//last_id=0;
		}
		$("#attr").on('click', '.del_attr', function(){
			var obj = $(this);
			//подправить
			/*
			if(obj.parent().find('input[type=hidden]').val()!=''){
				obj.parent().remove();
				return true;
			}*/
			obj.parent().remove();
			$.post( "/root/shop/product/delattributelist", { id: obj.data('del')}, function(){

			});

		});
		$('#add_attrebute').on('click', function(){
			++last_id;
			m++;
			var p = $('#add_attrebute').parent();
			var text = p.find('select option:selected').text();
			var id = p.find('select').val();
			var tmp = $('<div class="form-inline form-group field-productattributeslist-'+m+'-value required has-success"><label class="control-label" for="productattributeslist-'+m+'-value">'+text+':</label> <input type="text" id="productattributeslist-'+m+'-value" class="form-control" name="ProductAttributesList['+m+'][value]" value=""><input type="hidden" id="productattributeslist-'+m+'-value" class="form-control" name="ProductAttributesList['+m+'][attr_id]" value="'+id+'"> <label class="control-label btn btn-default del_attr" type="submit" data-del="'+last_id+'"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить?</label>		<div class="help-block"></div></div>');
			/*
			$.post( "/root/shop/product/addattributelist", { attr_id: id, product_id: product_id,  value: 's'}, function(data){
				alert(data);
				tmp.appendTo('#attr');
			});
			// */
			tmp.appendTo('#attr');
			//tmp.appendTo('#attr');
		});
		/*
        $('.elements_group_artcat').on('click', 'span.arrow_elements', function(){
            var first_element = $(this).parents('.elements_group');
            var action = $(this).data('move');
            var list_elements = $('.elements_group');
            var index_obj = list_elements.index(first_element);
            // for delete var id_first = first_element.data('key');
            var moveTo;
            var second_element;
            if (action == 'up') {
                moveTo = index_obj-1;
                action = 'before';
            } else {
                moveTo = index_obj+1;
                action = 'after';
            }
            second_element = $(list_elements).eq(moveTo);
            if(second_element.data('key') && moveTo>=0) {
                //alert('est');
                movingElements(first_element, second_element, action, '/root/bannerelements/sortorder');
            }
        });
        /**/

		$('.elements_group').on('click', 'span.arrow_elements', function(){
			var first_element = $(this).parents('.elements_group');
			var action = $(this).data('move');
			var list_elements = $('.elements_group');
			var index_obj = list_elements.index(first_element);
			// for delete var id_first = first_element.data('key');
			var moveTo;
			var second_element;
			if (action == 'up') {
				moveTo = index_obj-1;
				action = 'before';
			} else {
				moveTo = index_obj+1;
				action = 'after';
			}
			second_element = $(list_elements).eq(moveTo);
			if(second_element.data('key') && moveTo>=0) {
				//alert('est');
				movingElements(first_element, second_element, action, '/root/bannerelements/sortorder');
			}

		});

		function movingElements(first_element, second_element, action, url_sort){
			$.post( url_sort, { first_id: first_element.data('key'), second_id: second_element.data('key'), act: action}, function(data){
				if(action=='before'){
					second_element.before(first_element);
				} else {
					second_element.after(first_element);
				}
				alert(data);
			});
		}

		/*ar tmp = '<tr class="tr_images" data-numbmg="['+last_el+']"><th class="th_image"><img src="/uploads/analoyy.jpg" alt=""></th><th class="info_image "><div class="form-inline"><div class="form-group field-images-0-image required"><label class="control-label" for="images-0-image">Адрес изображения</label><div class="input-group"><input type="text" id="images-0-image" class="form-control" name="['+last_el+'][image]" value="'+value+'"><span class="input-group-btn"><button type="button" id="images-0-image_button" class="btn btn-default">Изменить изображение</button></span></div><div class="help-block"></div></div><label type="submit" class="btn btn-default del_img">Удалить изображение</label></div><div class="form-group field-images-0-id"><div class="help-block"></div></div><div class="form-group field-images-0-is_main required has-success"><label class="control-label" for="images-0-is_main">Основная фотография</label><input type="hidden" name="['+last_el+'][is_main]" value="0"><input type="checkbox" id="images-0-is_main" class="choose_image" name="['+last_el+'][is_main]" value="1"><div class="help-block"></div></div><div class="form-inline"><div class="form-group field-images-0-title required"><label class="control-label" for="images-0-title">Титл</label><input type="text" id="images-0-title" class="form-control" name="['+last_el+'][title]" value="222222222222" maxlength="256"><div class="help-block"></div></div><div class="form-group field-images-0-alt required"><label class="control-label" for="images-0-alt">Альт</label><input type="text" id="images-0-alt" class="form-control" name="Images['+last_el+'][alt]" value="" maxlength="256"><div class="help-block"></div></div</div></th></tr>';
		var tmp = '<tr class="tr_images" data-numbmg="'+last_el+'"><th class="th_image"><img src="'+value+'" alt=""></th><th class="info_image "><div class="form-inline"><div class="form-group field-images-0-image required"><label class="control-label" for="images-image-'+last_el+'">Адрес изображения</label><div class="input-group"><input type="text" id="images-image-'+last_el+'" class="form-control" name="Images['+last_el+'][image]" value="'+value+'"><span class="input-group-btn"><button type="button" id="images-image-'+last_el+'_button" class="btn btn-default image_button">Изменить изображение</button></span></div><div class="help-block"></div></div><label type="submit" class="btn btn-default del_img">Удалить изображение</label></div><div class="form-group field-images-0-id"><div class="help-block"></div></div><div class="form-group field-images-0-is_main required has-success"><label class="control-label" for="images-0-is_main">Основная фотография</label><input type="hidden" name="Images['+last_el+'][is_main]" value="0"><input type="checkbox" id="images-0-is_main" class="choose_image" name="Images['+last_el+'][is_main]" value="1"><div class="help-block"></div></div><div class="form-inline"><div class="form-group field-images-0-title required"><label class="control-label" for="images-0-title">Титл</label><input type="text" id="images-0-title" class="form-control" name="Images['+last_el+'][title]" value="" maxlength="256"><div class="help-block"></div></div><div class="form-group field-images-0-alt required"><label class="control-label" for="images-0-alt">Альт</label><input type="text" id="images-0-alt" class="form-control" name="Images['+last_el+'][alt]" value="" maxlength="256"><div class="help-block"></div></div</div></th></tr>';*/
		//потом надо будет все переписать... ипать
		function registrelf(k){
			mihaildev.elFinder.register("images-image-"+k, function(file, id){ $('#' + id).val(file.url).trigger('change', [file, id]);; return true;});
			$(document).on('click', '#images-image-'+k+'_button', function(){
				mihaildev.elFinder.openManager({"url":"/elfinder/manager?filter=image&callback=images-image-"+k+"&lang=ru","width":"auto","height":"auto","id":"images-image-"+k});
			});
		}
		
		//добавление картинок
		var last_el = $('.tr_images').last().data('numbimg');
		if(last_el == null) last_el=0;
		$('#add_images').on('click', function(){
			var obj = $('input[name=add_images]').val();
			obj = obj.replace(/\s+/g, '');
			if(obj == '') return false;
			obj = obj.split(',');
			$.each( obj, function( key, value ) {
				//alert(last_el);
				last_el++;
				var tmp = '<tr class="tr_images" data-numbmg="'+last_el+'">';
				tmp += '<th class="th_image"><img src="'+value+'" alt=""></th>';
				tmp += '<th class="info_image ">';
				tmp += '<div class="form-inline">';
				tmp += '<div class="form-group field-images-0-image required">';
				tmp += '<label class="control-label" for="images-image-'+last_el+'">Адрес изображения</label>';
				tmp += '<div class="input-group"><input type="text" id="images-image-'+last_el+'" class="form-control" name="Images['+last_el+'][image]" value="'+value+'"><span class="input-group-btn"><button type="button" id="images-image-'+last_el+'_button" class="btn btn-default image_button">Изменить изображение</button></span></div><div class="help-block"></div></div><label type="submit" class="btn btn-default del_img">Удалить изображение</label></div>'; //кнопки управления
				tmp += '<div class="form-group field-images-0-id"></div>';
				tmp += '<div class="form-inline"><div class="form-group field-images-0-title required"><label class="control-label" for="images-0-title" style="margin-left:5px"> Title</label>';
				tmp += '<input type="text" id="images-0-title" class="form-control" name="Images['+last_el+'][title]" value="" maxlength="256">';
				tmp += '<div class="help-block"></div></div>'; //титл
				tmp += '<div class="form-group field-images-0-alt required"><label class="control-label" for="images-0-alt"> Alt</label>';
				tmp += '<input type="text" id="images-0-alt" class="form-control" name="Images['+last_el+'][alt]" value="" maxlength="256">';
				tmp += '<input type="hidden" id="images-0-alt" class="form-control" name="Images['+last_el+'][is_main]" value="0">';
				tmp += '<div class="help-block"></div>';
				tmp += '</div</th></tr>';
				$(tmp).appendTo('#put_images');
				registrelf(last_el);
			});
			$('input[name=add_images]').val('');
		});
		
		//добавление основной изображения
		$('#change_main_image').on('change', function(){
			var img = $('#change_main_image').val();
			$('#main_image').html('<img src="' + img + '">');
		});
		
		//удаление картинок
		$('#put_images').on('click', '.del_img', function(){
			var obj = $(this).parents('.tr_images');
			if(obj.find('input.id_image').length>0){
				/*
				$.post('/root/image/delete', {"id": obj.find('input.id_image').val()}, function(data) {
					if(data == true)
					{
						obj.remove();
						//alert(obj.find('input.id_image').val());
					}
				});
				//*/
				obj.fadeOut('fast');
				
				obj.find('input.delete_image').val('1');
				//*/
				
			} else {
				obj.remove();
			}
			//
			
		});
		$('#put_images').on('click', '.choose_image', function(){
			if($(this).prop('checked') !== true) {
				$('.choose_image').removeAttr('checked');
			} else {
				$('.choose_image').removeAttr('checked');
				$(this).prop('checked', true);
			}

		});
		//добавление дополнительных полей
		var i=0;
		$('#add_field').on('click', function(){
			var tmp = $("#field_ .feedback_field_add").clone();
			tmp.find("input").each(function(k,v){ $(v).attr('name',$(v).attr('name').replace('[]','['+i+']')) })
			tmp.appendTo('#fields');
			i++;
		});
		$('#fields').on('click', '.del_field', function(){
			var t = $(this);
			yii.confirm("Вы точно хотите удалить поле и всю его информацию?", function(){
				var id = t.parents('.feedback_field').data('id'),
				tmp = "<input type='hidden' name='delete[][id]' value='"+id+"'/>";
				$(tmp).appendTo('#fields');
				t.parents('.feedback_field').fadeOut();/*
				$.post('/root/feedback/deletefield', {"id": t.data('del')}, function(data) {
					if(data == true)
					{
						t.parents('.feedback_field').remove();
					}
				});*/ 
			});
		});
		$('#fields').on('click', '.del_field_new', function(){
			$(this).parents('.feedback_field_add').remove();
		});
	})

	//фильтр для товаров
	$('a.get_ajax_item').on('click', function(){
		$('a.get_ajax_item').removeClass('active');
		$(this).addClass('active');
        $.get( $(this).attr('href'), function( data ) {
            $('#list_items').html(data);
        });
		return false;
	})
})

	

