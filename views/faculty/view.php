<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Faculty */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faculties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-view">
<!--
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
-->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id',
                'label' => 'Faculty #',
            ],
            [
                'attribute' => 'designation_id',
                'value' => $model->designation->title,
            ],
            'first_name',
            'last_name',
            'middle_name',
            'email:email',
            'birthday:date',
            'tin_number',
            'nationality',
            'status',
            'created_at:datetime',
        ],
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'panel' => [
            'heading' => 'Faculty Details',
            'type' => DetailView::TYPE_PRIMARY,
            'headingOptions' => [
                'template' => '{title}',
            ],
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'degree',
            'school',
            'date_graduate',
        ],
        'export' => false,
        'toolbar' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Educational Background',
        ],
    ]); ?>

</div>
