<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FacultyCourse */

$this->title = Yii::t('app', 'Create Faculty Course');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faculty Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-course-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'courses' => $courses,
    ]) ?>

</div>
