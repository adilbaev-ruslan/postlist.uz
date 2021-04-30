<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\ResetPassword */

$this->title = $title;
?>
<!-- Inner page
================================================== -->
<div id="inner-page">
    <div class="container">
        <?php if (Yii::$app->session->hasFlash('error')){ ?>
            <div class="alert m-t-50 alert-danger text-center ">
                <?= Yii::$app->session->getFlash('error'); ?>
            </div>
        <?php } if (Yii::$app->session->hasFlash('success')){ ?>
            <div class="alert m-t-50 alert-success text-center ">
                <?= Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php } ?>
    </div>
</div>
