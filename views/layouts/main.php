<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\models\Category;
use app\models\Page;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\components\LanguageDropdown;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrapper">

                <!-- Main -->
<div id="main">
    <div class="inner">
        <br>
        <?= LanguageDropdown::widget(); ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        
    </div>
</div>

<!-- Sidebar -->
    <div id="sidebar">
        <div class="inner">

            <!-- Search -->
                <section id="search" class="alt">
                    <form method="get" action="<?= Url::to(['/site/index']) ?>">
                        <input type="text" name="query" id="query" placeholder="Search" />
                    </form>

                </section>

            <!-- Menu -->
    <nav id="menu">
        <ul>
<?php
    $category = Category::find()->all();
    $pages = Page::find()->where(['status' => 'active'])->all();
?>
            <li><a href="<?= Yii::$app->homeUrl; ?>">Bas bet</a></li>
            <?php if($category) : ?>
                <?php foreach($category as $item) : ?>
                    <li><a href="<?= Url::to(['site/index', 'category' => $item->id]) ?>"><?= $item->name ?></a></li>
                <?php endforeach; ?>
            <?php endif; ?>
                
            <?php if($pages) : ?>
                <?php foreach($pages as $page) : ?>
                    <li><a href="<?= Url::to(['site/view', 'id' => $page->id]) ?>"><?= $page->title; ?></a></li>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if(Yii::$app->user->isGuest) : ?>
                <li><a href="<?= Url::to(['site/login']); ?>">Login</a></li>
                <li><a href="<?= Url::to(['site/signup']); ?>">Sign up</a></li>
            <?php else : ?>
                <li><a data-method="POST" href="<?= Url::to(['site/logout']); ?>">Logout(<?= Yii::$app->user->identity->full_name; ?>)</a></li>
            <?php endif; ?>
        </ul>
    </nav>

        </div>
    </div>

</div>

    
      

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
