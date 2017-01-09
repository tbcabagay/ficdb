<?php

use yii\helpers\Html;
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
                    'title' => Yii::t('app', 'Add Course'), 
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
