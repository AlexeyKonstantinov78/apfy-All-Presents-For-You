$('body').on('click', '.general_item_order_fast', function(){
    $.get('/product/ajax-product/'+$(this).data('id'), function(data){
        $('#callbackOrder')
            .modal('show')
            .find('#modalOrder')
            //.html( "<div class='modal_item_desc'><h3 class='text-center h3'>Быстрый заказ!</h3><img src='"+data.image+"' alt='"+data.name+"' class='modal_item_img' /> <span class='modal_item_name'>"+data.name+"</span> <section class='item_price text-right'><span class='item_price_number modal_item_price'>"+data.price+" руб.</span></section><form class='send_fast_order' action='/shop/cart/sendFastOrder'><input type='hidden' value='"+data.id+"' name='id'><input class='text-center none_outline form-control black_white_form  phone' type='text'  name='name' placeholder='Ваше имя' value='' /><input class='text-center none_outline form-control black_white_form' type='text'  name='phone' placeholder='Ваш телефон' value='' /><input class='text-center none_outline form-control black_white_form mail' type='text'  name='email' placeholder='Ваша почта' value='' /><button class='black_white_form form-control black_el gold_hover_el text-center text-uppercase transition_02'>Заказать</button></form></div>" );
            .html( "<div class='modal_item_desc'><h3 class='text-center h3'>Быстрый заказ!</h3><img src='"+data.image+"' alt='"+data.name+"' class='modal_item_img' /> <span class='modal_item_name'>"+data.name+"</span> <section class='item_price text-right'><span class='item_price_number modal_item_price'>"+data.price+" руб.</span></section><form class='send_fast_order' action='/shop/cart/sendfastorder'><input type='hidden' value='"+data.id+"' name='id'><input class='text-center none_outline form-control black_white_form phone' type='text'  name='Order[phone]' placeholder='Ваш телефон' value='' /><div class=\"form-group field-order-terms_of_use\"><label style='font-size: 12px;'><input type=\"hidden\" name=\"Order[terms_of_use]\" value=\"0\"><input type=\"checkbox\" id=\"order-terms_of_use\" name=\"Order[terms_of_use]\" value=\"1\"><span class=\"terms_of_use\">Я прочитал и согласен с условиями <a target=\"_blank\" class=\"transition_02\" href=\"/page/polzovatelskoe-soglashenie\">пользовательского соглашения</a> и <a target=\"_blank\" class=\"transition_02\" href=\"/page/politika-konfidencialnosti\">политики конфиденциальности</a>.</span></label><button class='form-control purpule_el  gold_hover_el  text-center text-uppercase transition_02' onclick=\"yaCounter48282563.reachGoal('orderItemFast'); return true;\">Заказать</button></form></div>" );
        $('#callbackOrder').find('input.phone').inputmask("phone", {"mask":"+7(999)-999-99-99"})
    })
});
$('#callbackOrder').on('submit', '.send_fast_order', function(){
    $.post($(this).attr('action'), $(this).serialize(), function(data){
        if(data.errors == false){
            $('#callbackOrder')
                .find('#modalOrder')
                .fadeOut('fast', function(){
                    $(this).html("<div class='modal_item_desc'><h3 class='text-center h3'>Спасибо за заказ!</h3><p>"+data.status+"</p></div>");
                })
                .fadeIn('fast');
        } else {
            alert(data)
        }
    });
    return false;
});