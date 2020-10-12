<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */



$this->params['breadcrumbs'][] = $this->title;
/* for example form fields
<?= $form->field($model, 'name', [
    //'template' => "{label}\n<i class='fa fa-user'></i>\n{input}\n{hint}\n{error}"
    'template' => "\n<i class=\"icon-MaleFemale\"></i>\n{input}",
    'options' => ['class' => 'input-with-icon col-xs-12'],
])->textInput([
    'placeholder' => 'Ваше имя',
    'class' => 'validate-required'
]); ?>
// end example */
?>

<main style="margin-top: 170px; margin-bottom: 50px">
    <section class="text-center">
        <hr class="gold_hr"/>
        <h1 class="h1 text-center h_gold">Контакты</h1>
    </section>
    <section class="container" style="margin-bottom:50px">
        <div class="row">
            <div class="col-xs-12 col-md-4 text-center">
                <i class="fa fa-address-card-o" aria-hidden="true" style="font-size: 50px; display:block; margin-top:20px; margin-bottom:10px"></i>
                <p></p>
            </div>
            <div class="col-xs-12 col-md-4 text-center">
                <i class="fa fa-phone" aria-hidden="true" style="font-size: 50px; display:block; margin-top:20px; margin-bottom:10px"></i>
                <p><b>Позвоните нам</b></p>
                <p></p>
            </div>
            <div class="col-xs-12 col-md-4 text-center">
                <i class="fa fa-reply-all" aria-hidden="true" style="font-size: 50px; display:block; margin-top:20px; margin-bottom:10px"></i>
                <p><b>Напишите нам</b></p>


            </div>
        </div>
    </section>
</main>