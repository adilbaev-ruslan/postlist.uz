<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\data\Pagination;

$this->title = 'My Yii Application';
?>


        <?php if(!empty($dataProvider)) : ?>
            <section>
            <div class="posts">
            <?php foreach($dataProvider->getModels() as $model) : ?>
        
                <article>
                <a href="<?= Url::to(['post/view', 'id' => $model->id]) ?>" class="image"><img src="<?= Yii::$app->homeUrl ?>uploads/<?= $model->image ?>" alt="" /></a>
                <h3><?= $model->title ?></h3>
                <p><?= $model->description ?></p>
                <ul class="actions">
                    <li><a href="<?= Url::to(['post/view', 'id' => $model->id]) ?>" class="button">More</a></li>
                </ul>
            </article>
            
            <?php endforeach; ?>
            </div>
</section>
                <?php
                    echo \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemOptions' => ['class' => 'item'],
                    ]);
                ?>
                <style>
                    .summary{
                        display: none;
                    }
                    .list-view .item{
                        display: none;
                    }
                </style>
        <?php else : ?>
            <h1>Null</h1>
        <?php endif; ?>
        
    