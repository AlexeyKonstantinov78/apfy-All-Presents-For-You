$(document).ready( function(){
    /*Всплывашки в шапке*/
    $('#top_bar .all_collapse').on('click', function () {
        var el = $('#top_bar').find($(this).data('target'));
        if(!el.hasClass('in')) {
            el.collapse('show');
        }
        $('.other_collapse.in').collapse('hide');
    });

    //менюшка
    $('#collapseMenu_1 .ver_2_sub_menu a').hover(function(){

        var imgChange = $(this).data('img');
        console.log(imgChange);
        $('#menu_img_cat').attr('src', imgChange);
    });

    //$('.add_to_cart').on('click')
    /*инициализировать все элементы на страницы, имеющих атрибут data-toggle="tooltip", как компоненты tooltip(всплывающие подсказки)*/
    $('.general_item_order_fast[data-toggle="tooltip"]').tooltip();

    //поиск
    function querysend(ob){
        var query = ob.find("input[type=text]").val();
        query = query.trim();
        if(query == 'Поиск' || query == '' || query.length < 3)
            location.href = '/searchlong';
        else
            location.href = '/search/'+encodeURIComponent(query)+'';
        return false;
    }
    $(".searching").on("submit", function(){
        return querysend($(this));
    })

    /*scroll*/
    $(window).scroll(function(){
        //кнопочка
        if ($(window).scrollTop() > 500) {
            $('#down_to_up').addClass('active');
        }
        else {
            $('#down_to_up').removeClass('active')
        }
    });
    $('#down_to_up').on('click', function () {
        $('html,body').animate({scrollTop: 0}, 1000);
    })
    // var distanceTop = $('.media_banner').offset().top;
    // var menuScroll = $('#cont_navbar').offset().top;
    // //меню
    // if ($(window).scrollTop() > menuScroll) {
    //     $('#navbar').addClass('navBarFixed');
    // } else {
    //     $('#navbar').removeClass('navBarFixed');
    // }
    /*end scroll*/
    
});

