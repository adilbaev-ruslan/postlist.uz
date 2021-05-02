<?php

use yii\helpers\Html;
use app\components\Functions;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'Update Category: ' . Functions::translateJson($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Functions::translateJson($model->name), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 
    	$model->translate_name = json_decode($model->name, true);
    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
