
//fancybox
if($(window).width() > 991){
    $(function(){
        var itemObj = [];
        $.each($("#item_images img"), function(k,v) {
            itemObj.push({
                href: $(v).data('href'),
                //title: 'test'
            });
        });

        $('#item_image').on('click', 'img', function () {
            $.fancybox.open(itemObj, {
                padding : 0,
                autoResize: false,
                autoSize: false,
                autoHeight: false,
                maxWidth: 900,
                //type: 'image',
            });
            return false;
        });
    });

}

//изменение главной картинки товара
$("#item_images ").on('click', '.item_img', function(){
    var d = $(this);
    $('#item_image').fadeOut('fast', function(){
        $(this).html('<img src="'+d.data('href')+'" alt="'+d.attr('alt')+'">')
    }).fadeIn('fast');
});
//кнопки добавление и удаления
$('.item_quant').on('click', function () {
    var action = $(this).data('action'),
        quant = Number($('#item_quant').val());
    if(action == 'add')
        $('#item_quant').val(quant+1);
    if(action == 'delete' && quant>1)
        $('#item_quant').val(quant-1);
});
$('#item_quant').on('change', function(){
    if(isNaN(Number($(this).val())) == true || Number($(this).val()) < 1)
        $('#item_quant').val('1');
});
// var images = {
//     1: [
//         {
//             href : 'http://fancyapps.com/fancybox/demo/1_b.jpg',
//             title : 'Gallery 1 - 1'
//         },
//         {
//             href : 'http://fancyapps.com/fancybox/demo/2_b.jpg',
//             title : 'Gallery 1 - 2'
//         },
//         {
//             href : 'http://fancyapps.com/fancybox/demo/3_b.jpg',
//             title : 'Gallery 1 - 3'
//         }
//     ],
//     2: [
//         {
//             href : 'http://fancyapps.com/fancybox/demo/4_b.jpg',
//             title : 'Gallery 2 - 1'
//         },
//         {
//             href : 'http://fancyapps.com/fancybox/demo/5_b.jpg',
//             title : 'Gallery 2 - 2'
//         }
//     ]
// };
//
// $(".open_fancybox").click(function() {
//     $.fancybox.open(images[ $(this).index() + 1], {
//         padding : 0
//     });
//
//     return false;
// });
//var itemObj = {};