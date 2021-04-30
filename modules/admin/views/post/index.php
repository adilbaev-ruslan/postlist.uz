<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Category;
use app\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php 
        $category = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        $user = ArrayHelper::map(User::find()->all(), 'id', 'full_name');
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'title',
            // 'category.name',
            [
                'attribute' => 'category_id',
                'value' => function($model) {
                    return $model->category->name;
                },
                'filter' => $category,
            ],
            // 'user.full_name',
            [
                'attribute' => 'user_id',
                'value' => function($model) {
                    return $model->user->full_name;
                },
                'filter' => $user,
            ],
            // 'description',
            //'content:ntext',
            // 'count_view',
            [
                'attribute' => 'count_view',
                'headerOptions' => ['style' => 'width: 70px'],
            ],
            // 'status',
            [
                'attribute' => 'status',
                'headerOptions' => ['style' => 'width: 120px'],
                'filter' => ['active' => 'active', 'inactive' => 'inactive'],
            ],
            // 'create_at',
            [
                'attribute' => 'create_at',
                'headerOptions' => ['style' => 'width: 150px'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
