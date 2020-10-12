<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 23.05.2018
 * Time: 12:15
 */
use app\models\Pvz;
$models = Pvz::find()->orderBy(['region' => SORT_ASC])->asArray()->all();
$info = 'уточняйте по телефону';
$this->registerJsFile('/js/plugins/cdekwidget/widjet.js', ['depends' => 'yii\web\YiiAsset', 'id' => 'ISDEKscript']);
$this->registerJsFile('/js/plugins/cdekwidget/pvz.js', ['depends' => 'yii\web\YiiAsset', 'id' => 'ISDEKscript']);
$this->registerCssFile('/js/plugins/cdekwidget/scripts/style.css');
?>
<style>
    .CDEK-widget__delivery-type {display: none}
</style>
<main style="margin-top: 170px; margin-bottom: 50px">
    <section class="text-center">
        <hr class="gold_hr"/>
        <h1 class="h1 text-center h_gold"><?=$model->name?></h1>
</section>
<section class="container">
    <div class="row">
        <div class="col-xs-12">
            <div id="widjetCdek"></div>
            <?=$model->text?>

            <?php if($models): ?>
                <ul style="margin-top: 30px">
                    <?php foreach ($models as $k=>$v):?>
                        <li>
                            <p>
                                <b style="font-size: 120%"><?=$v['region']?>,</b>
                                <b style="font-size: 120%">г. <?=$v['town']?>,</b>
                                <?=$v['street']?>,
                                <?=empty($v['house']) ? '' : 'Дом '.$v['house'].','?>
                                <?=empty($v['office']) ? '' : 'Офис '.$v['office'].','?>
                                Телефоны: <?=empty($v['phone']) ? '' : $v['phone']?>,
                                Время работы: <?=empty($v['clock']) ? '' : $v['clock']?>.
                            </p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>


        </div>
    </div>
</section>
</main>