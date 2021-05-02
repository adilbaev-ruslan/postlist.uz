<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\Functions;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
            	'class' => 'yii\grid\SerialColumn',
            	'contentOptions'=>[ 'style'=>'width: 30px'],
            ],

            // 'name',
            [
                'attribute' => 'name',
                'value' => function($model) {
                    return Functions::translateJson($model->name);
                },
            ],

            [
            	'class' => 'yii\grid\ActionColumn',
            	'contentOptions'=>[ 'style'=>'width: 70px'],
            ],
        ],
    ]); ?>


</div>
