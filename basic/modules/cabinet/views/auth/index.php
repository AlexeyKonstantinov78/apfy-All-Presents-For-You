
<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
$this->registerCssFile('/css/site/pagesCss/cabinet.css');
?>
<!---header>
    <?=Breadcrumbs::widget([
    'homeLink' => [
        'label' => 'Главная',
        'url' => Yii::$app->homeUrl,
    ],
    'links' => isset(Yii::$app->params['breadcrumbs']) ? Yii::$app->params['breadcrumbs'] : [],
    'options' => [ 'id' => 'breadcrumbs', 'class' => 'text-center'],
])?>
</header-->
<main class="container" style="margin-bottom: 50px">
    <section class="text-center">
        <hr class="gold_hr">
        <h1 class="h1 text-center h_gold text-uppercase" style="font-weight: 200">Авторизация</h1>
    </section>
    <section class="row" id="auth">
        <div class="col-xs-12">
            <div class="rootFlex flexJustifyCenter flexAlignItemsStart">
                <div class="auth-block">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form-auth',
                        'options' => ['class' => 'auth-from form-default auth-from_input border-radius_none'],
                    ]); ?>
                    <?= $form->field($model, 'mail', [
                        'inputOptions' => [
                            'placeholder' => 'Ваша почта:',
                        ],
                        'labelOptions' => [ 'class' => 'form-group' ]
                    ])->textInput([
                        'autofocus' => true,
                        //'class' => '',
                    ])-> label(false) ?>
                    <?= $form->field($model, 'password', [
                        //'template' => "<div class=\"input-with-icon\">{label}<i class=\"icon icon-Security-Check\"></i>{input} <br/> {error}</div>",
                        'inputOptions' => [
                            'placeholder' => 'Пароль:',
                        ],
                        'labelOptions' => [ 'class' => 'form-group' ]
                    ])->passwordInput([
                        //'autofocus' => true,
                        //'class' => '',
                    ])-> label(false) ?>
                    <?= Html::submitButton('Войти', ['class' => 'return--pass red_but_font_filt transition_02', 'name' => 'login-button']) ?>
                    <?php ActiveForm::end(); ?>
                    <a href="/cabinet/registration/reset" class="auth-link transition_02">Востановить пароль?</a>
                </div>
                <div class="auth-block">
                    <div class="auth-reg">
                        <h3 class="text-uppercase text-left h4">Преимущество регистрации</h3>
                        <ul class="auth-reg_ul">
                            <li>Оповещение о специальных предложениях</li>
                            <li>Возможность просматривать историю заказов</li>
                            <li>Быстрое оформление заказа</li>
                        </ul>
                        <a href="/cabinet/registration" class="auth-reg_link red_but red_but_font_filt transition_02 text-center">
                            Регистрация <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
