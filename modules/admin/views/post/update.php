<?php

use yii\helpers\Html;
use app\components\Functions;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = 'Update Post: ' . Functions::translateJson($model->title);
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Functions::translateJson($model->title), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 
    	$model->translate_title = json_decode($model->title, true);
    	$model->translate_description = json_decode($model->description, true);
    	$model->translate_content = json_decode($model->content, true);
    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
