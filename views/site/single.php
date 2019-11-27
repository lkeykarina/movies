<?php

use yii\helpers\Url;

?>

<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                        <a href="blog.html" style="text-align: center"><img src="<?= $article->getImage(); ?>" style="max-height: 300px;
    width: auto" alt=""></a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">


                            <h1 class="entry-title"><?= $article->title ?>
                            </h1>
                            <h6>
                                <a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id]) ?>"> <?= $article->category->title ?></a>
                            </h6>

                        </header>
                        <div class="entry-content">
                            <?= $article->content ?>
                        </div>
                        <div class="decoration">
                            <? foreach ($tags as $tag): ?>
                                <a  href="<?= Url::toRoute(['site/tag', 'id'=>$tag->id, 'title'=>$tag->title])?>" class="btn btn-default"><?= $tag->title; ?></a>
                            <? endforeach; ?>
                        </div>

                        <div class="social-share">
							<span
                                    class="social-share-title pull-left text-capitalize"> On <?= $article->getDate(); ?></span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-eye"></i></a></li>
                                <?= (int)$article - viewed ?>
                            </ul>
                        </div>
                    </div>
                </article>

                <!-- end bottom comment-->
                <?= $this->render('/partials/comment', [
                    'article' => $article,
                    'comments' => $comments,
                    'commentForm' => $commentForm
                ]) ?>
            </div>
            <?= $this->render('/partials/sidebar', [
                'popular' => $popular,
                'categories' => $categories
            ]); ?>
        </div>
    </div>
</div>
<!-- end main content-->