<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'id',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $column) {
                    return $model->getStatusValue($model->status);
                }
            ],
            'created_at:datetime',
            [
                'attribute' => 'last_login',
                'value' => function ($model, $key, $index, $column) {
                    if (intval($model->last_login) === 0) {
                        return '(not set)';
                    } else {
                        return Yii::$app->formatter->asDateTime(Html::encode($model->last_login));
                    }
                },
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'viewOptions' => ['class' => 'btn-modal'],
                'updateOptions' => ['class' => 'btn-modal'],
            ],
        ],
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'app-pjax-container',
            ],
        ],
        'export' => false,
        'toolbar' => [
            ['content' =>
                Html::a('<i class="fa fa-plus"></i>', ['create'], [
                    'title' => Yii::t('app', 'Add User'), 
                    'class' => 'btn btn-success btn-modal',
                    'data-pjax' => 0,
                ]) . ' ' .
                Html::a('<i class="fa fa-repeat"></i>', ['index'], [
                    'class' => 'btn btn-default', 
                    'title' => Yii::t('app', 'Reset Grid'),
                    'data-pjax' => 0,
                ]),
            ],
            '{toggleData}',
        ],
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => 'Grid View',
        ],
    ]); ?>
</div>
