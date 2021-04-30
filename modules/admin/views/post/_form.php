<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;
use dosamigos\tinymce\TinyMce;
use dosamigos\selectize\SelectizeTextInput;
use app\models\TagAssign;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
    <div class="col-md-9">
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
                    <?= $form->field($model, 'translate_title[' . $language . ']')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'translate_description[' . $language . ']')->textarea(['rows' => 2]) ?>

                    <?= $form->field($model, 'translate_content[' . $language . ']')->widget(TinyMce::className(), [
                        'options' => ['rows' => 13],
                        'language' => 'ru',
                        'clientOptions' => [
                            'plugins' => [
                                "advlist autolink lists link charmap print preview anchor",
                                "searchreplace visualblocks code fullscreen",
                                "insertdatetime media table contextmenu paste"
                            ],
                            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                        ]
                    ]);?>
                  </div>
                  <?php $j++; ?>
            <?php endforeach; ?>
        </div>   
    </div>
    <div class="col-md-3">
         <?php 
            $data = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        ?>

        <?= $form->field($model, 'category_id')->dropDownList($data); ?>
        <?= $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', ], ['prompt' => '']) ?>

        <?php 
        	if (!$model->isNewRecord) {
        		$tags = ArrayHelper::map(TagAssign::find()->where(['post_id' => $model->id])->all(), 'id', 'tag.name');
        		$tags_str = implode(',', $tags);
        	} else {
        		$tags_str = '';
        	}

        	echo \dosamigos\selectize\SelectizeTextInput::widget([
            'name' => 'Post[tag]',
            'loadUrl' => ['tag/list'],
            'value' => $tags_str,
            'clientOptions' => [
                'plugins' => ['remove_button'],
                'valueField' => 'keyword',
                'labelField' => 'keyword',
                'searchField' => ['keyword'],
                'create' => true,
                'delimiter' => ',',
                'persist' => false,
                'createOnBlur' => true,
                'preload'=> false
            ]
        ]);
        	
        ?>

        <?php if($model->image) :  ?>
            <?= Html::img('/uploads/' . $model->image, ['style' => 'width:100%']) ?>
        <?php endif; ?>

        <?= $form->field($model, 'image')->fileInput() ?> 
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>  
    </div>
  </div>
<?php ActiveForm::end(); ?>

</div>
