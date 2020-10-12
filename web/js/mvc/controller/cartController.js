var cartTmp = function (data, href) {
    return '<section class="item cart_element cart_item_id_' + data.id + '"><div class="container-fluid"><div class="row"><div class="col-sm-4"><img src="' + data.image + '" class="row"/></div><div class="col-sm-8"><a href="' + data.href + '" target="_blank" class="item_href transition_02" title="' + data.name + '">' + data.name + '</a><div class="cart_item_price"><span class="item_change_quant quant_remove_to transition_02" data-action="remove" data-id="' + data.id + '"><i class="fa fa-minus-circle" aria-hidden="true"></i></span><span class="cart_item_quant">' + data.quantity + '</span><span class="item_change_quant quant_add_to transition_02" data-action="add" data-id="' + data.id + '"><i class="fa fa-plus-circle" aria-hidden="true"></i></span> X <span class="item_price">' + data.price + '</span></div></div></div></div><span class="cart_item_delete item_del_all fa fa-times-circle transition_02" aria-hidden="true" data-id="' + data.id + '"></span> </section>';
}
var CartObj = new Cart();
$('#cart_items').toggleClass('visible_hidden', CartObj.arrayItems.length > 0);
$('body').on('click', '.general_item_pay, .quant_add_to', function () {
    var obj = $(this), quant = null;
    if (obj.hasClass('item_add_to_order')) {
        quant = $('#item_quant').val();
    }
    CartObj.setCart(obj.data('id'), quant, function (data) {
        if (CartObj.arrayItems.indexOf(data.id) !== -1) {
            $('.cart_item_id_' + data.id + ' .cart_item_quant').text(data.quantity);
            $('.cart_item_id_' + data.id + ' .cart_item_quant_input').val(data.quantity);
        } else {
            $('#items').append(cartTmp(data, obj.data('href')));
            $('#callbackOrder').modal('show').find('#modalOrder').html("<div class='modal_item_desc'><h3 class='text-center'>Товар добавлен в корзину!</h3><img src='" + data.image + "' alt='" + data.name + "' class='modal_item_img' /> <span class='modal_item_name'>" + data.name + "</span><a class='form-control purpule_el  gold_hover_el  text-center text-uppercase transition_02' style='margin-top: 20px; margin-bottom: 20px; font-weight: 400' href='/shop/cart/list'>Оформить заказ?</a>");
            setTimeout(function () {
                $('#callbackOrder').modal('hide');
            }, 2000);
        }
        if (CartObj.arrayItems.indexOf(data.id) == -1) CartObj.arrayItems.push(data.id);
        $('#cart_items').toggleClass('visible_hidden', CartObj.arrayItems.length > 0);
        $('.total_price').html(data.total).data('total', data.total);
        $('#cart .all_collapse small').html(data.count);
    });
});
$('body').on('click', '.item_del_all', function () {
    CartObj.setCart($(this).data('id'), 0, function (data) {
        $('.cart_item_id_' + data.id).remove();
        CartObj.arrayItems.splice(CartObj.arrayItems.indexOf(data.id), 1);
        $('#cart_items').toggleClass('visible_hidden', CartObj.arrayItems.length > 0);
        $('.empty_order').toggleClass('in', CartObj.arrayItems.length == 0);
        $('.total_price').html(data.total).data('total', data.total);
        $('#cart .all_collapse small').html(data.count);
    });
});
$('body').on('click', '.quant_remove_to', function () {
    CartObj.removeItem($(this).data('id'), function (data) {
        $('.cart_item_id_' + data.id + ' .cart_item_quant').text(data.quantity);
        $('.cart_item_id_' + data.id + ' .cart_item_quant_input').val(data.quantity);
        $('.total_price').html(data.total).data('total', data.total);
    });
});