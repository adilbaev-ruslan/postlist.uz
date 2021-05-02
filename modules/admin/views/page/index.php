<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\Functions;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'title',
            [
                'attribute' => 'title',
                'value' => function($model) {
                    return Functions::translateJson($model->title);
                }
            ],
            // 'content:ntext',
            'count_view',
            'status',
            'create_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
