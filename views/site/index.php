<?php

use yii\helpers\Html;
use yii\authclient\widgets\AuthChoice;
use kartik\widgets\Growl;

/* @var $this yii\web\View */

$this->title = 'Home';
?>
<div class="site-index">

    <div class="col-lg-4 col-lg-offset-4">
        <div class="site-img">
            <?= Html::img('@web/img/UPOU_seal_BW.jpg', ['class' => 'img-responsive center-block']) ?>
        </div>
        <hr>
        <div class="text-center">
            <p class="lead"><?= Html::encode(Yii::$app->params['appName']) ?></p>
            <p><?= Html::a('<i class="fa fa-google-plus"></i> Click to Login', ['site/auth', 'authclient' => 'google'], ['class' => 'btn btn-danger']) ?></p>
        </div>

        <?php if (Yii::$app->getSession()->hasFlash('error')): ?>
            <?= Growl::widget([
                'type' => Growl::TYPE_DANGER,
                'body' => Yii::$app->getSession()->getFlash('error'),
            ]) ?>
        <?php endif; ?>
    </div>
</div>
