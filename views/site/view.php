<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\Functions;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = Functions::translateJson($model->title);
\yii\web\YiiAsset::register($this);
?>
<section>
    <header class="main">
        <h2><?= $this->title ?></h2>
    </header>

    <div>
        <?= Functions::translateJson($model->content); ?>
    </div>

    <p>Count View: <?= $model->count_view; ?> | Create at: <?= date('d-m-Y, H:i', strtotime($model->create_at)) ?></p>

</section>