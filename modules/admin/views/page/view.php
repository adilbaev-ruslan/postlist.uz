<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\Functions;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = Functions::translateJson($model->title);
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-view">

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

    <?php $languages = Yii::$app->params['languages']; ?>

    <ul class="nav nav-tabs">
            <?php $i = 0; foreach($languages as $language => $lable) : ?>
                <li class="<?= ($i == 0) ? 'active' : '' ?>"><a data-toggle="tab" href="#<?= $language ?>"><?= $lable ?></a></li>
                <?php $i++; ?>
            <?php endforeach; ?>
        </ul>

        <div class="tab-content">
            <?php $j = 0; foreach($languages as $language => $lable) : ?>
                <div id="<?= $language ?>" class="tab-pane fade in <?= ($j == 0) ? 'active' : '' ?>">
                    <br>
                    <table class="table table-striped table-bordered detail-view">
                        <tbody>
                            <tr>
                                <th>Title</th>
                                <td><?= Functions::translateJson($model->title, $language) ?></td>
                            </tr>
                            <tr>
                                <th>Content</th>
                                <td><?= Functions::translateJson($model->content, $language) ?></td>
                            </tr>
                        </tbody>
                    </table>  
                  </div>
                  <?php $j++; ?>
            <?php endforeach; ?>
        </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'count_view',
            'status',
            'create_at',
        ],
    ]) ?>

</div>
