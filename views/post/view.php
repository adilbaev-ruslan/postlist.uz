<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;
\yii\web\YiiAsset::register($this);
?>
<section>
    <header class="main">
        <h2><?= $this->title ?></h2>
    </header>

    <span class="image main"><img src="<?= Yii::$app->homeUrl ?>web/uploads/<?= $model->image ?>" alt="" /></span>

    <div>
        <?= $model->content; ?>
    </div>

    <p>Category: <?= $model->category->name ?> | Author: <?= $model->user->full_name; ?> | Count View: <?= $model->count_view; ?> | Create at: <?= date('d-m-Y, H:i', strtotime($model->create_at)) ?></p>

</section>