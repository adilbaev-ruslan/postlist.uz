<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user mdm\admin\models\User */

$resetLink = Url::to(['site/confirm-email','token'=>$token], true);
?>
<div class="confirm-email">
    <p><?= Yii::t('yii','Hello'); ?> <?= Html::encode($user->full_name) ?>,</p>

    <p><?= Yii::t('yii','Follow the link below to confirm your account:'); ?></p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
