<?php
/**/
if(\Yii::$app->user->identity->status == 0){
$js = <<<JS
    $('#repeat_confirm').on('click', function(){
        $.ajax({
            url: '/cabinet/registration/repeatconfirmmail?send=true',
            type: 'GET',
            success: function(data) {
                if(data){
                    $('#modalCabinetHeader')
                    .html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 class="text-center h3" style="font-size: 20px;margin-top: 10px;margin-bottom: 10px;">Письмо отправлено</h3>');
                    $('#modalCabinetBody')
                    .html('<p>Письмо успешно отправлено, можно посмотреть почту!</p><p class="text-center"><button class="closeCabinet closeCabinetNavRepeatSend return--pass red_but_font_filt transition_02">Закрыть!</button></p>');
                    $('#callbackCabinet').modal('show');
                }
            },
        });
        return false;
    });
    $('#callbackCabinet').on('click', '.closeCabinetNavRepeatSend', function(){
        $('#callbackCabinet').modal('hide');
    });
JS;
$this->registerJs($js);
}
/**/
?>




<nav class="cabinet_nav">
    <a href="/cabinet/" class="cabinet_nav_link transition_02">Профиль</a>
    <a href="/cabinet/orderhistory" class="cabinet_nav_link transition_02">Мои заказы</a>
    <a href="/cabinet/delivery" class="cabinet_nav_link transition_02">Адрес доставки</a>
    <a href="/cabinet/logout" class="cabinet_nav_link transition_02">Выход</a>
    <!--
    <a href="/cabinet/" class="cabinet_active cabinet_nav_link transition_02">Мой личный кабинет</a>

    <a href="/cabinet/" class="cabinet_nav_link transition_02">Мои желания</a>
    <a href="/cabinet/" class="cabinet_nav_link transition_02">Новости и предложения</a>
    <a href="/cabinet/" class="cabinet_nav_link transition_02">Тикет</a>
    -->
    <?php if(\Yii::$app->user->identity->status == 0): ?>
    <p style="color:#e30000 !important; font-size: 12px">Вы не подтвердили почту, необходимо подтвердить регистрацию на сайте.</p>
    <p style="color:#e30000 !important; font-size: 12px">Иначе аккаунт будет удален в течении недели!</p>
    <a href="/cabinet/registration/repeatconfirmmail"
            id="repeat_confirm"
            class="cabinet_nav_link transition_02 text-center none_outline"
            style="color:#e30000 !important;">
        Отправить письмо!
    </a>
    <?php endif; ?>
</nav>
