<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user mdm\admin\models\User */

$resetLink = Url::to(['site/confirm-email','token'=>$token], true);
?>
<?= Yii::t('yii','Hello'); ?> <?= $user->full_name ?>,

<?= Yii::t('yii','Follow the link below to confirm your account:'); ?>

<?= $resetLink ?>
