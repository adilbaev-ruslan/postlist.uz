<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

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
                    <?= $form->field($model, 'translate_name[' . $language . ']')->textInput(['maxlength' => true]) ?>
                </div>
                <?php $j++; ?>
            <?php endforeach; ?>
        </div>  

    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
