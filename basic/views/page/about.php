<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
//Url::toRoute('/about');
?>


<main style="margin-bottom: 50px; margin-top: 170px">
    <section class="text-center">
        <hr class="gold_hr"/>
        <h1 class="h1 text-center h_gold"><?=$model->name?></h1>
    </section>
    <section class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="cols_2_description text-left first_p">
                    <?=$model->text?>
                </div>
            </div>
        </div>
    </section>
</main>

