<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FacultyEducationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Faculty Educations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-education-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'id',
            // 'faculty_id',
            'degree',
            'school',
            'date_graduate',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'updateOptions' => ['class' => 'btn-modal'],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'update') {
                        return Url::toRoute(['update', 'faculty_id' => Yii::$app->request->get('faculty_id'), 'id' => $model->id]);
                    } else if ($action === 'delete') {
                        return Url::toRoute(['delete', 'faculty_id' => Yii::$app->request->get('faculty_id'), 'id' => $model->id]);
                    }
                }
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
                Html::a('<i class="fa fa-plus"></i>', ['create', 'faculty_id' => Yii::$app->request->get('faculty_id')], [
                    'title' => Yii::t('app', 'Add Educational Background'), 
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
            'before' => Html::a('Go to Faculty', ['faculty/index'], ['class' => 'btn btn-info', 'data-pjax' => 0]),
        ],
    ]); ?>
</div>
