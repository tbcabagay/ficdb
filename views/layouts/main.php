<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\FontAwesomeAsset;
use app\assets\CustomeTheme;
use app\components\SbAdminSidebarWidget;
use yii\bootstrap\Modal;

CustomeTheme::register($this);
FontAwesomeAsset::register($this);

$identity = Yii::$app->user->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>body{font-family: 'Roboto', sans-serif; font-weight: 300;}</style>
</head>
<body>
<?php $this->beginBody() ?>

    <div id="wrapper">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->params['appName'],
            'brandUrl' => Yii::$app->homeUrl,
            'renderInnerContainer' => false,
            'options' => [
                'class' => 'navbar-default navbar-static-top',
                'style' => 'margin-bottom: 0;',
            ],
        ]);
        echo Nav::widget([
            'items' => [
                [
                    'label' => '<i class="fa fa-cog fa-fw"></i> Settings',
                    'items' => [
                        ['label' => 'Office', 'url' => ['office/index']],
                        '<li class="divider"></li>',
                        ['label' => 'Program', 'url' => ['program/index']],
                        ['label' => 'Course', 'url' => ['course/index']],
                        '<li class="divider"></li>',
                        ['label' => 'Designation', 'url' => ['designation/index']],
                        '<li class="divider"></li>',
                        ['label' => 'User', 'url' => ['user/index']],
                        '<li class="divider"></li>',

                    ],
                ],
                Yii::$app->user->isGuest ? '' : [
                    'label' => '<i class="fa fa-user fa-fw"></i>',
                    'items' => [
                        ['label' => 'Profile', 'url' => ['user/profile', 'id' => $identity->id]],
                        '<li class="divider"></li>',
                        ['label' => 'Logout (' . $identity->email . ')', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                    ],
                ],
            ],
            'encodeLabels' => false,
            'options' => ['class' =>'navbar-top-links navbar-right'],
        ]);

        echo SbAdminSidebarWidget::widget([
            'items' => [
                Html::a('Notices', ['notice/index']),
                Html::a('Faculties', ['faculty/index']),
                Html::a('Templates', ['template/index']),
            ],
        ]);

        NavBar::end();
        ?>
        
        <div id="page-wrapper">
            <div class="container-fluid">
                <?= $content ?>
            </div>
        </div>

    </div>

<?php Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'header' => '<span class="modal-header-content"></span>',
    'clientOptions' => [
        'backdrop' => 'static',
    ],
]);
Modal::end(); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
