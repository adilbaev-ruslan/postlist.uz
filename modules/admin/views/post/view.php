<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\TagAssign;
use yii\helpers\ArrayHelper;
use app\components\Functions;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = Functions::translateJson($model->title);
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php 
        $tags = ArrayHelper::map(TagAssign::find()->where(['post_id' => $model->id])->all(), 'id', 'tag.name');
        $tags_str = implode(',', $tags);
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            // 'title',
            [
                'attribute' => 'title',
                'value' => Functions::translateJson($model->title),
            ],
            [
                'attribute' => 'image',
                'value' => $model->image ? Html::img('/uploads/' . $model->image, ['style' => 'width:200px']) : null,
                'format' => 'html',
            ],
            'category.name',
            [
                'attribute' => 'tag',
                'value' => $tags_str,
                'format' => 'raw',
            ],
            'user.full_name',
            // 'description',
            [
                'attribute' => 'description',
                'value' => Functions::translateJson($model->description),
                'format' => 'html',
            ],
            // 'content:html',
            [
                'attribute' => 'content',
                'value' => Functions::translateJson($model->content),
                'format' => 'html',
            ],
            'count_view',
            'status',
            'create_at',
        ],
    ]) ?>

</div>
