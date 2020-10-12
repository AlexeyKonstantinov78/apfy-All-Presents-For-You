<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 20.07.2018
 * Time: 15:43
 */
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <h1 class="col-xs-12"><?= Html::encode($this->title) ?></h1>
        <div class="col-xs-12">
            <div class="form-group" style="padding-bottom: 20px; border-bottom: 1px solid #000; margin-bottom: 20px">
                <div class="form-inline">
                    <label class="control-label" style="margin-right: 20px">Обновление раздела распродаж!</label>
                    <a href="/root/settings/discountitem" class="btn btn-default">Обновить</a>
<!--                    <button type="submit" id="add_attrebute" class="btn btn-default">Обновить</button>-->
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group" style="padding-bottom: 20px; border-bottom: 1px solid #000; margin-bottom: 20px">
                <div class="form-inline">
                    <label class="control-label" style="margin-right: 20px">Обновление Тигерну!</label>
                    <a href="/root/settings/tigernu" class="btn btn-default">Обновить</a>
<!--                    <button type="submit" id="add_attrebute" class="btn btn-default">Обновить</button>-->
                </div>
            </div>
        </div>
    </div>
</div>


