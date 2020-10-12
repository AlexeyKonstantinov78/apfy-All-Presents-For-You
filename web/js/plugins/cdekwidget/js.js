// var cdekWidjet = new ISDEKWidjet ({
//     defaultCity: 'Москва', //какой город отображается по умолчанию
//     cityFrom: 'Москва', // из какого города будет идти доставка
//     country: 'Россия', // можно выбрать страну, для которой отображать список ПВЗ
//     link: 'widjetCdek', // id элемента страницы, в который будет вписан виджет
//     servicepath: '/js/plugins/cdekwidget/service.php' //
// });




$( document ).ready(function(){
    //вставка цены доставки
    var cdekWidjet;
    $('#order-delivery').on('change', function () {
        if($(this).hasClass('delivery_active')) return false;
        clearInput();
        if($(this).val() == 0) {
            $('.choose_delivery').removeClass('delivery_active');
            $('.choose_delivery_apfy').addClass('delivery_active');
            deliveryApfy();
        } else {
            cdekWidjet = new ISDEKWidjet({
                hideMessages: false,
                showErrors: false,
                showLogs: true,
                defaultCity: 'Москва', //какой город отображается по умолчанию
                cityFrom: 'Москва', // из какого города будет идти доставка
                country: 'Россия', // можно выбрать страну, для которой отображать список ПВЗ
                link: 'widjetCdek', // id элемента страницы, в который будет вписан виджет
                servicepath: '/js/plugins/cdekwidget/service.php', //
                choose: true, //скрыть кнопку выбора
                // goods: [{
                // 	length: 10,
                // 	width: 10,
                // 	height: 10,
                // 	weight: 1
                // }],
                onReady: onReady,
                //goods: objCdek,
                onChoose: onChoose,
                onChooseProfile: onChooseProfile,
                onCalculate: calculated
            });
            $('.choose_delivery').removeClass('delivery_active');
            $('.choose_delivery_cdek').addClass('delivery_active');
            deliveryCDEK();
        }
        //payment();
    });


    function onReady() {
        console.log('ready');
        $.each(objCdek, function (i,elem) {
            s = Number(elem.s);
            w = Number(elem.w);

            addGood(s, w);


            // var mas = cdekWidjet.cargo.get();
            // console.log(mas);
        });

        console.log(cdekWidjet.cargo.get());
        //console.log(objCdek);
    }

    function onChoose(wat) {
        deliveryCDEK(1, wat.city, wat);
        // console.log('chosen', wat);
        // serviceMess(
        //     'Выбран пункт выдачи заказа ' + wat.id + '<br>' +
        //     'цена ' + wat.price + '<br>' +
        //     'срок ' + wat.term + ' дн. <br>' +
        //     'город ' + wat.city
        // );
    }

    function onChooseProfile(wat) {
        deliveryCDEK(2, wat.city, wat);
        // console.log('chosenCourier', wat);
        // serviceMess(
        //     'Выбрана доставка курьером в город ' + wat.city + ' <br>' +
        //     'цена ' + wat.price + '<br>' +
        //     'срок ' + wat.term + ' дн.'
        // );
    }


    function calculated(params){
        ipjq("#delPricePVZ").html(params.profiles.pickup.price + " руб.");
        ipjq("#delPriceCourier").html(params.profiles.courier.price + " руб.");
        deliveryCDEK(0, params.city, params);
        //alert("Доставка на ПВЗ будет стоить "+ params.profiles.pickup.price + " руб."); // выведем оповещение о стоимости доставки
    }

    function clearInput() {
        $('#form_order .clear_input input').val('').attr('placeholder', '');
        $('#orderRight .total_price.item_price_number_new').text($('#orderRight .total_price.item_price_number_new').data('total'));
    }

    function deliveryApfy(){
        window.servmTimeout = setTimeout(function () {
            var pr = $('.total_price').eq(0).text();
            var price = 0;
            var total = $('#orderRight .total_price.item_price_number_new').data('total');
            //total = Number(total.replace(' ',''));
            if(total.length > 3)
                total = Number(total.replace(' ',''));
            else
                total = Number(total);

            if(pr.length > 3)
                pr = Number(pr.replace(' ',''));
            else
                pr = Number(pr);
            if(pr>4000)
                price = 0;
            else
                price = 350;
            $('.delivery_price').text(price);
            var nubmer = Number(total)+Number(price),
                format = String(nubmer).replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1 ');
            $('#orderRight .total_price.item_price_number_new').text(format);
            $('#order-delivery_choose').val(0); //кем доставка 0 - курьер, 1 - ПВЗ
            $('#order-delivery_price').val(price); //цена доставки
        }, 500);

    }

    function getCity(id, callback){
        return $.get( '/shop/cart/ajaxcity', {id: id}, function( data ) {
            callback(data);
        });
    }

    function deliveryCDEK(profile, city, obj){
        if(profile == 0){
            $('.delivery_price').html('<span style="color:red">Выберите способ доставки</span>');
        }

        if(profile == 1){
            city = getCity(city, function(data){
                $('#order-town').val(data).attr('placeholder', data);
            });
            $('#order-street').val(obj.PVZ.Address).attr('placeholder', city);

            var total = $('#orderRight .item_price_number_new').data('total');
            if(total.length>3)
                total = Number(total.replace(' ',''));
            else
                total = Number(total);
            var nubmer = Number(total)+Number(obj.price),
                format = String(nubmer).replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1 ');
            if(Number(total)>10000){
                nubmer = Number(total);
                obj.price = 0;
                format = String(nubmer).replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1 ');
            }
            $('#orderRight .total_price.item_price_number_new').text(format);
            $('.delivery_price').text(obj.price);
            $('#order-delivery_choose').val(1); //кем доставка 0 - курьер, 1 - ПВЗ
            $('#order-delivery_price').val(obj.price); //цена доставки
        }
        if(profile == 2){
            city = getCity(city, function(data){
                $('#order-town').val(data).attr('placeholder', data);
            });

            $('#order-street').val('').attr('placeholder', '');

            var total = $('#orderRight .item_price_number_new').data('total');
            if(total.length>3)
                total = Number(total.replace(' ',''));
            else
                total = Number(total);
            var nubmer = Number(total)+Number(obj.price),
                format = String(nubmer).replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1 ');
            if(Number(total)>10000){
                nubmer = Number(total);
                obj.price = 0;
                format = String(nubmer).replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1 ');
            }
            $('#orderRight .total_price.item_price_number_new').text(format);
            $('.delivery_price').text(obj.price);
            $('#order-delivery_choose').val(0); //кем доставка 0 - курьер, 1 - ПВЗ
            $('#order-delivery_price').val(obj.price); //цена доставки
        }

    }

    //Добавление товара
    function addGood(s, w) {
        cdekWidjet.cargo.add({
            length: s,
            width: s,
            height: s,
            weight: w
        });
        cdekWidjet.onCalculate
        // $('#cntItems').html ( parseInt($('#cntItems').html()) + 1 );
        // $('#weiItems').html ( parseInt($('#weiItems').html()) + 2 );

    }


    //Добавление товаров при загрузке
    function addGoods() {
        console.log(objCdek);
        $.each(objCdek, function (i,elem) {
            if(!elem == true) return;
            //console.log(objCdek);
            s = Math.cbrt(Number(elem.sZero)*Number(elem.quant));
            w = Number(elem.wZero)*Number(elem.quant);
            addGood(s, w);
            // var mas = cdekWidjet.cargo.get();
            // console.log(mas);
        });
        // $('#cntItems').html ( parseInt($('#cntItems').html()) + 1 );
        // $('#weiItems').html ( parseInt($('#weiItems').html()) + 2 );
        cdekWidjet.onCalculate;
    }


    $('body').on('click', '.order_item_quant .item_change_quant, .item_change_quant',  function(){
        var id = $(this).data('id');
        var action = $(this).data('action');
        $.each(objCdek, function (i,elem) {
            if(!elem == true) return;
            if(elem.id == id) id = i;
        });

        if(action == 'delete' || action == 'remove'){

            if(objCdek[id].quant > 1) {
                objCdek[id].quant = objCdek[id].quant - 1;
            } else {
                return false;
            }
            //addGoods();
        } else {
            objCdek[id].quant = objCdek[id].quant + 1;
        }

        if($('#order-delivery').val() == 1) {

            cdekWidjet.cargo.reset();
            addGoods();
        }
        if($('#order-delivery').val() == 0) {
            deliveryApfy();
        }


    });

    //добавление и удаление на плюсики и минусики
    $('#order_list').on('change', 'input.cart_item_quant_input', function(){
        var id = $(this).data('id');
        var valQuant = Number($(this).val());
        $.each(objCdek, function (i,elem) {
            if(!elem == true) return;
            if(elem.id == id) id = i;
        });
        if(valQuant == 0) return false;
        objCdek[id].quant = valQuant;
        if($('#order-delivery').val() == 1) {

            cdekWidjet.cargo.reset();
            addGoods();
        }
        if($('#order-delivery').val() == 0) {
            deliveryApfy();
        }


    })

    //удаление товара полностью
    $('#order_list').on('click', '.order_item_delete, .item_del_all', function(){
        var  id = $(this).data('id');
        $.each(objCdek, function (i,elem) {
            if(!elem == true) return;
            if(elem.id == id) id = i;
        });

        if(objCdek.length<=1) {
            cdekWidjet.cancel;
            return true;
        }
        delete objCdek[id];
        if($('#order-delivery').val() == 1) {

            cdekWidjet.cargo.reset();
            addGoods();
        }
        if($('#order-delivery').val() == 0)
            deliveryApfy();

    })

    serviceMess = function (text) {
        clearTimeout(window.servmTimeout);
        ipjq('#service_message').show().html(text);
        window.servmTimeout = setTimeout(function () {
            ipjq('#service_message').fadeOut(1000);
        }, 4000);
    }

    //способ оплаты
    function payment() {
        if($('#order-delivery').val() == 0){
            $('#order-payment_choose option:last-child').remove();
        }
        if($('#order-delivery').val() == 1){
            $('#order-payment_choose ').append('<option value="1">Банковской картой при получении</option>')
        }
    }
    //payment();




});