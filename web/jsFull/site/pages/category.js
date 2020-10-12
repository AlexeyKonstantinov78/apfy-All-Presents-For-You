// $(document).ready( function(){
//     //*
//     $('#activeFiltres').on('click', function (event) {
//
//         $.get( $('#filters').attr('action'), $('#filters').serialize(), function( data ) {
//             $('#category_products').html( data );
//         });
//         //event.preventDefault();
//         //console.log( $(this).attr('action') );
//     });
//     //*/
//     if($(window).width() > 991){
//         $(window).scroll(function(){
//             var top_aside = $('aside').offset().top;
//             var the_end = $('article').offset().top;
//             the_end = the_end - 850;
//             if ($(window).scrollTop() > top_aside && $(window).scrollTop() < the_end) {
//                 $('aside form').addClass('form_fixed');
//             } else {
//                 $('aside form').removeClass('form_fixed');
//             }
//         })
//     }
// });