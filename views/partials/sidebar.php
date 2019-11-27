<?php

use yii\helpers\Url;

?>
<div class="col-md-4" data-sticky_column>
    <div class="primary-sidebar">

        <aside class="widget border pos-padding">
            <h3 class="widget-title text-uppercase text-center">Categories</h3>
            <ul>
                <? foreach ($categories as $category): ?>
                    <li>
                        <a href="<?= Url::toRoute(['site/category', 'id' => $category->id]); ?>"><?= $category->title ?></a>
                        <span class="post-count pull-right"> (<?= $category->getArticlesCount(); ?>)</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
        <aside class="widget">
            <h3 class="widget-title text-uppercase text-center">Popular Posts</h3>

            <? foreach ($popular as $article): ?>
                <div class="popular-post">


                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="popular-img" style="text-align: center"><img
                                src="<?= $article->getImage(); ?>" style="max-height: 150px;  width: auto" alt="">

                        <div class="p-overlay"></div>
                    </a>

                    <div class="p-content">
                        <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"
                           class="text-uppercase"><?= $article->title ?></a>
                        <span class="p-date"><?= $article->date; ?></span>

                    </div>
                </div>
            <? endforeach; ?>
        </aside>
    </div>
</div>