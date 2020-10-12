/*google analitics*/
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-99355892-1', 'auto');
ga('send', 'pageview');
/*end google*/
/**
 * Created by straengel on 13.02.2017.
 */
$(document).ready( function(){
    $('.loader').addClass('loader--fade');
    $('.transition--fade').addClass('transition--active');
    //скроллы
    //медленная прокрутка сайта
   // if (window.addEventListener) window.addEventListener('DOMMouseScroll', wheel, false);
    //window.onmousewheel = document.onmousewheel = wheel;
    function querysend(){
        var query = $(".search_unic input[type=text]").val();
        query = query.trim();
        if(query == 'Поиск' || query == '') return false;

        location.href = '/search/'+encodeURIComponent(query)+'';
        return false;
    }



    $(".search_unic form[name=search]").on("submit", function(){
        return querysend();
    })
    function wheel(event) {
        var delta = 0;
        if (event.wheelDelta) delta = event.wheelDelta / 120;
        else if (event.detail) delta = -event.detail / 3;

        handle(delta);
        if (event.preventDefault) event.preventDefault();
        event.returnValue = false;
    }

    function handle(delta) {
        var time = 400;
        var distance = 400;

        $('html, body').stop().animate({
            scrollTop: $(window).scrollTop() - (distance * delta)
        }, time );
    }
    //события скролла
    var window_height=$(window).height();
    $(window).on( "scroll", function(){
        //меню
        if($(this).scrollTop() >= 70) {
            if($('.nav-bar').hasClass('nav--fixed') === false) $('.nav-bar').addClass('nav--fixed');
        } else {
            if($('.nav-bar').hasClass('nav--fixed') === true) $('.nav-bar').removeClass('nav--fixed');
        }

        //стрелка наверх
        if($(this).scrollTop() >= window_height) {
            if($('.top-link').hasClass('active') === false) {
                $('.top-link.animated_active').fadeIn('slow');
                $('.top-link.animated_active').addClass('active');
            }
        } else {
            if($('.top-link').hasClass('active') === true) {
                $('.top-link.animated_active').fadeOut('slow');
                $('.top-link.animated_active').removeClass('active');
            }
        }
    });

    //accordion menu top
    /*first
    $('.drop_head_multi_column').on('click', function(){
        var at = $(this).attr('href'),
            par = $(this).parent();
        //$('.multi-column_my .multi-column_drop_active').removeClass('multi-column_drop_active');
        if(!$(at).hasClass('in')){
            par.addClass('multi-column_drop_active');
        } else {
            par.removeClass('multi-column_drop_active');
        }
    })
    /*end first*/
    /*second*/
    $('.drop_head_multi_column').on('click', function(){
        var par = $(this).parent();
        $('.multi-column_my .multi-column_drop_active').removeClass('multi-column_drop_active');
        if(!par.find('.collapse').hasClass('in')){
            par.parents('.multi-column_my').find('.collapse.in').collapse('hide');
            par.find('.collapse').collapse('toggle');
            par.addClass('multi-column_drop_active');
        } else {
            par.parents('.multi-column_my').find('.collapse').collapse('hide');
        }
    })
    //раскрытие мобильного меню
    $(".nav-mobile-toggle i").on('click', function () {
        $('.nav-bar.nav--absolute').addClass('mobile_menu_active');
    });
    //закрытие мобильного меню
    $('#menu_close').on('click', function () {
        $('.nav-bar.nav--absolute').removeClass('mobile_menu_active');
    })
    /*end second*/

    //scroll top
    $('.top-link.animated_active').on( 'click', function () { // При клике по кнопке "Наверх" попадаем в эту функцию
        /* Плавная прокрутка наверх */
        $('body, html').animate({
            scrollTop: 0
        }, 2000);
        return false;
    });

    //корзина
    //открытие корзины
    var c = $('.cart-overview');
    $('.interface-bag').on('click', function(){
        if(!c.hasClass('notification--reveal')) {
            c.addClass('notification--reveal');
        } else {
            if(c.hasClass('notification--dismissed')) {
                c.removeClass('notification--dismissed');
            }
            else {
                c.addClass('notification--dismissed');
            }
        }
		
    });
    $('.notification-close-cross').on('click', function(){
        if(c.hasClass('notification--dismissed')) {
            c.removeClass('notification--dismissed');
        }
        else {
            c.addClass('notification--dismissed');
        }
    })
    //функции разные блин

    //добавление товара в корзину
    function add_product(data, href, quant){
        if(data !== undefined){
            //var tmp = '<li id="id_prod_'+data.id+'" data-id="'+data.id+'" class="display_table"><div class="item__image display_table_cell vertical_middle"><a href="'+href+'"><img alt="'+data.name+'" src="'+data.image+'" /></a></div><div class="item__detail display_table_cell vertical_middle"><a href="'+href+'"><span class="transition_leaner_02">'+data.name+'</span></a><span class="h6"><span class="quantity_item">'+quant+'</span> x '+href+' руб.</span></div><div class="item__remove del_item" title="Удалить товар" data-id="'+data.id+'></div></li>';
            var tmp = '<li id="id_prod_'+data.id+'" data-id="'+data.id+'" class="display_table"><div class="item__image display_table_cell vertical_middle" style="background-image: url('+data.image+')"><a href="'+href+'"><img alt="'+data.name+'" src="'+data.image+'" /></a></div><div class="item__detail display_table_cell vertical_middle"><a href="'+href+'"><span class="transition_leaner_02">'+data.name+'</span></a><span class="h6"><span class="quantity_item">'+quant+'</span> x '+data.price+' руб.</span></div><div class="item__remove del_item" title="Удалить товар" data-id="'+data.id+'"></div></li>';

            if( ($('#id_prod_'+data.id).length)===1  ) {
                $('#id_prod_'+data.id+' .quantity_item').html(Number(quant));
            } else {
                $(tmp).appendTo('#basket');
            }
            $('span.total_cost').html(data.total);
        } else {
            return false;
        }
    }

    //Изменение цифирки на корзине
    function cartreload(data){

        if(data == undefined){
            $('.count_item').html('0');
        }
        else {
            $('.count_item').html('('+data.count+'шт)');
        }
        if (data == true) $('.count_item').html('0 шт.');
    }
    //добавление модального окошечка
    function show_modal(data){
        $('#callback').modal('show')
            .find('#modalCallback').html( "<div class='row'><div class='col-sm-4'><img src='"+data.image+"' style='text-align:center'></div><div class='col-sm-8 text-center'><h4>Товар <b>"+data.name+"</b> успешно добавлен в корзину.</h4><div class=' item_button'> <a class='button btn btn-primary' href='/shop/cart/list'>Оформить заказ</a> <button type='button' class='btn close_mod btn-primary' data-dismiss='modal_cart' aria-hidden='true'>Продолжить</button></div></div>" );
        //$('#modalHeaderCallback').html('<h2>'+data.name+'</h2>');
        $('#modalHeaderCallback h2').remove();
        $('<h2>'+data.name+'</h2>').appendTo('#modalHeaderCallback');
        $('#modalCart .header').remove();
        $('.close_mod').on('click', function(){
            $(this).parents('#callback').modal('hide');
        })
    }

    //Добавление товара в корзину из товара и из категории
    $('.add_but_cart').on('click', function(){
        //var parent_block = $(this).closest('.add_to_cart');
        var parent_block = $(this).parent(),
        id = parent_block.find('.id_product').val(),
        href = parent_block.data('href');
        if($('main .quantity_in_item').length >> 0) {
            var quant = Number($('.quantity_in_item').val());

            if($('ul#basket li#id_prod_'+id).length >> 0) quant = quant + Number($('#id_prod_'+id+' .quantity_item').html());
            //thumb: 327 - передаем размер для картинки в оформление заказа
            $.post( '/shop/cart/add', {id: id, thumb: 327}, function( data ) {
                $.post( '/shop/cart/quantity', {id: id, quantity: quant}, function( data ) {
                    $('span.totalCost').html(data.total);
                    show_modal(data);
                    //cartreload(data);
                    add_product(data, href, quant);
                });
            });

        }
        else {
            $.post( '/shop/cart/add', {id: id, thumb: 327}, function( data ) {
                show_modal(data);
                //cartreload(data);
                add_product(data, href, 1);
            });
        }
    });

    //Удаление товара
    $('#basket').on( 'click', '.del_item', function(){
    var el = $(this);
    $.post( '/shop/cart/delete', {id: $(this).data('id')}, function( data ) {
        el.parents('.prod_in_trush').remove();
        $('#id_prod_'+data.id).remove();
        $('span.total_cost').html(data.total);
        //cartreload(data);
    });
})

});

