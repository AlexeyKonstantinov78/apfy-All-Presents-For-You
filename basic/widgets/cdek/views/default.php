<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJsFile('/js/plugins/cdekwidget/widjet.js', ['depends' => 'yii\web\YiiAsset', 'id' => 'ISDEKscript']);
$this->registerJsFile('/js/plugins/cdekwidget/js.js', ['depends' => 'yii\web\YiiAsset', 'id' => 'ISDEKscript']);
$this->registerCssFile('/js/plugins/cdekwidget/scripts/style.css');


?>
<div class="row">
    <div class="col-xs-12">
        <div id="widjetCdek"></div>

    </div>
</div>

