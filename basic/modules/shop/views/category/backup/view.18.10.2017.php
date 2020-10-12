<?php if(count($products) > 0) { ?>
    <?php //если есть товары начало ?>
    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-3 col-sm-12 col-xs-12">
                <div class="sidebar">
                    <!--div class="sidebar__widget">
                        <h6>Search Site</h6>
                        <hr>
                        <form method="post">
                            <div class="input-with-icon">
                                <i class="icon-Magnifi-Glass2"></i>
                                <input type="search" placeholder="Type Here">
                            </div>
                        </form>
                    </div>
                    <!--end widget-->
                    <? //может потом переписать на виджет ??? tolook ?>

                    <!--end widget-->
                    <div class="sidebar__widget">
                        <h6>Фильтры</h6>
                        <hr>
                        <ul class="tag-cloud">
                            <li>
                                <a href="#" class="btn btn--sm btn--square">
                                    <span class="btn__text">
                                        цвет
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn--sm btn--square">
                                    <span class="btn__text">
                                        Цвет белый
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn--sm btn--square">
                                    <span class="btn__text">
                                        Цвет серый
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn--sm btn--square">
                                    <span class="btn__text">
                                        Цена по возрастанию
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn--sm btn--square">
                                    <span class="btn__text">
                                       Цена по убыванию
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--end widget-->
                    <div class="sidebar__widget">
                        <h6>About Us</h6>
                        <hr>
                        <p>
                            We're a digital focussed collective working with individuals and businesses to establish rich, engaging online presences.
                        </p>
                    </div>
                    <!--end widget-->
                </div>
            </aside>
            <main class="col-md-9 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="sidebar__widget col-xs-12">
                        <h6>Товары</h6>
                        <hr>
                    </div>
                    <?php
                    //перебор товаров
                    //может добавить возможность добавления товара из категории
                    //вся подвязка добавления будет по id в классе add_to_cart
                    ?>
                    <?php foreach($products as $k=>$p): ?>
                        <?php //var_dump($p->mainImage->image); exit; ?>
                        <a href="/product/<?=$p->seoTags->slug?>" class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="card card-7">
                                <div class="card__image display_table text-center">
                                    <div class="display_table_cell">
                                        <img alt="<?=$p->name?>" src="<?=$p->mainImage->thumb(null, 327)?>">
                                    </div>
                                </div>
                                <div class="card__body boxed bg--white">
                                    <div class="card__title">
                                        <h5><?=$p->name?></h5>
                                    </div>
                                    <div class="card__price">
                                        <!--span class="type--strikethrough rub_after">129</span-->
                                        <span class="rub_after"><?=$p->price?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>

                    <?php // конец перебора товаров ?>
                </div>
                <div class="row">
                    <div class="pagination-container">
                        <hr />
                        <?=yii\widgets\LinkPager::widget(array(
                            'pagination' => $pages,
                        ));?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php //если есть товары конец ?>
<?php } else { ?>
    <main class="container" >
        <h3 style="margin:30px 0;text-align:center;font-style: italic;font-size: 30px;opacity: 0.7;">Подкатегории</h3>
        <div class="row" id="sub_categories">
            <?php foreach($model->children as $ch) {?>
                <div class="col-md-4 col-xs-6 main_info_wide_grid" >
                    <a href="<?='/category/'.($ch->seoTags->slug == null ? $ch->id : $ch->seoTags->slug)?>" class="">
                        <div class="hover-element hover-element-1 row">
                            <div class="hover-element__initial">
                                <img alt="Pic" src="/img/tmp/work6.jpg">
                                <h4 class="unElement"><?=$ch->name?></h4>
                            </div>
                            <div class="hover-element__reveal" data-overlay="9">
                                <div class="boxed">
                                    <?php if (!empty($ch->description)){ ?>
                                        <span>
                                    <em>Описание:</em>
                                </span>
                                    <?php } ?>
                                    <?=$ch->description?>
                                </div>
                            </div>
                        </div>

                    </a>
                </div>
            <?php } ?>
        </div>
    </main>
<?php } ?>