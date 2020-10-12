/*Функции*/
/*Добавление в корзину*/
/*Html шаблон товара в корзине*/
function addItemTmp(data, href, quant){
    if(data !== undefined){
        //var tmp = '<li id="id_prod_'+data.id+'" data-id="'+data.id+'" class="display_table"><div class="item__image display_table_cell vertical_middle"><a href="'+href+'"><img alt="'+data.name+'" src="'+data.image+'" /></a></div><div class="item__detail display_table_cell vertical_middle"><a href="'+href+'"><span class="transition_leaner_02">'+data.name+'</span></a><span class="h6"><span class="quantity_item">'+quant+'</span> x '+href+' руб.</span></div><div class="item__remove del_item" title="Удалить товар" data-id="'+data.id+'></div></li>';
        //var tmp = '<li id="id_prod_'+data.id+'" data-id="'+data.id+'" class="display_table"><div class="item__image display_table_cell vertical_middle" style="background-image: url('+data.image+')"><a href="'+href+'"><img alt="'+data.name+'" src="'+data.image+'" /></a></div><div class="item__detail display_table_cell vertical_middle"><a href="'+href+'"><span class="transition_leaner_02">'+data.name+'</span></a><span class="h6"><span class="quantity_item">'+quant+'</span> x '+data.price+' руб.</span></div><div class="item__remove del_item" title="Удалить товар" data-id="'+data.id+'"></div></li>';
        //var tmp = '<li id="id_prod_'+data.id+'" data-id="'+data.id+'" class="display_table"><div class="item__image display_table_cell vertical_middle" style="background-image: url('+data.image+')"><a href="'+href+'"><img alt="'+data.name+'" src="'+data.image+'" /></a></div><div class="item__detail display_table_cell vertical_middle"><a href="'+href+'"><span class="transition_leaner_02">'+data.name+'</span></a><span class="h6"><span class="quantity_item">'+quant+'</span> x '+data.price+' руб.</span></div><div class="item__remove del_item" title="Удалить товар" data-id="'+data.id+'"></div></li>';
        var tmp = '<section id="cart_item_id_'+data.id+'" data-id="'+data.id+'" class="item cart_element cart_item_id_'+data.id+'"><div class="container-fluid"><div class="row"><div class="col-sm-4"><img src="'+data.image+'" class="row"/></div><div class="col-sm-8"><a href="'+href+'" class="item_href transition_02" title="'+data.name+'">'+data.name+'</a><div class="cart_item_price"><span class="cart_item_quant">'+quant+'</span> X <span class="item_price">'+data.price+'</span></div></div></div></div><span class="cart_item_delete" onclick="deleteItemCarts('+data.id+')"><img class="transition_02" src="/img/site/icons/close.svg" style="width: 17px; height: 17px;"></span> </section>';
        if( ($('#cart_item_id_'+data.id).length)===1  ) {
            var elQuant=$('#cart_item_id_'+data.id+' .cart_item_quant'),
                allQuant = Number(elQuant.html()) + Number(quant);
            elQuant.html(allQuant);
        } else {
            $(tmp).appendTo('#items');
        }
        changeNumElementsVisible();

        modalItemShow(data);
    } else {
        return false;
    }
}
/*цифирка в корзине, сообщение о том что корзина пуста*/
/*нужно еще добавить открытие основной цены и кнопки перехода в оформление заказа*/
function changeNumElementsVisible(){
    var n = Number($('#items .item').length);
    if(n>0) {
        $('#cart_message').removeClass('in');
        $('#cart_items .cart_element_visible.total_cost, #cart_items .cart_element_visible.button_order').addClass('in');
    }
    else {
        $('#cart_message').addClass('in');
        $('#cart_items .cart_element_visible.total_cost, #cart_items .cart_element_visible.button_order').removeClass('in');
    }
    $('#cart .all_collapse small').html(n);
}
/*показать модальное окно добавление товара*/
function modalItemShow(data) {
    $('#callbackOrder').modal('show')
        .find('#modalOrder').html( "<div class='modal_item_desc'><img src='"+data.image+"' alt='"+data.name+"' class='modal_item_img' /> <span class='modal_item_name'>"+data.name+"</span>" );
    $('<h4 class="modal_item_header text-center">Добавлено в корзину</h4>').appendTo('#modalOrderHeader');
    //;
    setTimeout(function(){$('#callbackOrder').modal('hide');}, 2000);
}
/*Добавить товар addItemCarts*/
function addItemCarts(id, href){
    $.post( '/shop/cart/add', {id: id, quantity: quant, thumb: 327}, function( data ) {
        addItemTmp(data, href, quant);
        $('#total_price').html(data.total);
    });
}
/*Удалить товар*/
function deleteItemCarts(id){
    $.post( '/shop/cart/delete', {id: id}, function( data ) {
        $('#cart_item_id_'+data.id).remove();
        $('#total_price').html(data.total);
        changeNumElementsVisible();
    });
}
/*Количество товара*/
function quantItems(id, quant, href) {
    $.post( '/shop/cart/quantity', {id: id, quantity: quant}, function( data ) {
        $('#total_price').html(data.total);
        addItemTmp(data, href, quant);
    });
}
/*купить в один клик*/
function payOneClick(id){
    alert('В один клик');
}

/*Ajax передача товаров или товара на удаление или добавление*/
/*а надо ли?*/
/*
function ajaxCart(id, quant, action) {
    if(action == 'add'){
        $.post( '/shop/cart/add', {id: id, thumb: 327}, function( data ) {
            changeNumOrder();
        });
    }

}
/*конец дообавления товара*/