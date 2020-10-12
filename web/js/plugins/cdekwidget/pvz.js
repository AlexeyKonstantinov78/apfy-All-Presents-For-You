let cdekWidjet;
$( document ).ready(function(){
    cdekWidjet = new ISDEKWidjet({
        hideMessages: false,
        showErrors: false,
        showLogs: false,
        defaultCity: 'Москва', //какой город отображается по умолчанию
        cityFrom: 'Москва', // из какого города будет идти доставка
        country: 'Россия', // можно выбрать страну, для которой отображать список ПВЗ
        link: 'widjetCdek', // id элемента страницы, в который будет вписан виджет
        servicepath: '/js/plugins/cdekwidget/service.php', //
        choose: true, //скрыть кнопку выбора
    });
});