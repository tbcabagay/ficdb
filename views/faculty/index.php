<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\growl\GrowlAsset;
use kartik\base\AnimateAsset;

GrowlAsset::register($this);
AnimateAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\FacultySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Faculties');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'id' => 'app-grid-faculty',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'id',
            // 'designation_id',
            'first_name',
            'last_name',
            'middle_name',
            // 'email:email',
            // 'birthday',
            // 'tin_number',
            // 'nationality',
            // 'status',
            'created_at:datetime',

            [
                'class' => 'kartik\grid\ActionColumn',
                'viewOptions' => ['class' => 'btn-modal'],
                'updateOptions' => ['class' => 'btn-modal'],
            ],
        ],
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->id];
        },
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
                    'title' => Yii::t('app', 'Add Faculty'), 
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
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => 'Grid View',
            'before' => Html::button('<i class="fa fa-file-text"></i> Notices', [
                'id' => 'add-notice',
                'class' => 'btn btn-danger',
                'data-value' => Url::to(['notice/create']),
                'value' => 0,
                'disabled' => true,
            ]) . ' ' .
            Html::button('<i class="fa fa-book"></i> Assign Courses', [
                'id' => 'add-faculty-course',
                'class' => 'btn btn-warning',
                'data-value' => Url::to(['faculty-course/index']),
                'value' => 0,
                'disabled' => true,
            ]) . ' ' .
            Html::button('<i class="fa fa-graduation-cap"></i> Educational Background', [
                'id' => 'add-faculty-educational-bg',
                'class' => 'btn btn-info',
                'data-value' => Url::to(['faculty-education/index']),
                'value' => 0,
                'disabled' => true,
            ]),
        ],
    ]); ?>
</div>
