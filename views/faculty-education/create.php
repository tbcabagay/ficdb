<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FacultyEducation */

$this->title = Yii::t('app', 'Create Faculty Education');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faculty Educations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-education-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
