<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 30.11.2016
 * Time: 18:59
 */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;
use app\widgets\menu\MenuWidget;
AdminAsset::register($this);
//app\assets\BootboxAsset::overrideSystemConfirm();
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
		
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/root/">Админк панель</a>
            </div>
            <!-- Top Menu Items -->


            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <?= MenuWidget::widget(['tmp_menu' => 'top_admin']) ?>
                <?//= MenuWidget::widget(['tmp_menu' => 'aside_admin']) ?>
                <?//= MenuWidget::widget(['tmp_menu' => 'top_admin_main']) ?>
            </div>
        </nav>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?= Html::encode($this->title) ?>
                        </h1>
                        <?= Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
							'homeLink' => [
								'label' => 'Главная панель',  // required
								'url' => '/root/',
							],
                            'options' => [
                                'class' => 'breadcrumb',
                            ],
                        ]) ?>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-sm-12">
                        <?= $content ?>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
	
    <!-- /#wrapper -->
	
    <?php $this->endBody() ?>
	
	<script src="/js/root/admin.js"></script>
    </body>
    </html>
<?php $this->endPage() ?>