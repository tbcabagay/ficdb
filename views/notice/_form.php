<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Notice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notice-form">

    <?php $form = ActiveForm::begin([
        'id' => 'app-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        //'validationUrl' =>  ($model->isNewRecord) ? ['validate-create'] : ['validate-update', 'id' => $model->id],
        'validationUrl' =>  ['validate', 'faculty_id' => Yii::$app->request->get('faculty_id')],
        'options' => [
            'autocomplete' => 'off',
        ],
    ]); ?>

    <?= $form->field($model, 'course_id')->widget(Select2::className(), [
        'data' => $facultyCourses,
        'options' => [
            'placeholder' => '- Select -',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'template_id')->radioList($templates) ?>

    <?= $form->field($model, 'reference_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'semester')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'academic_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_course_start')->textInput() ?>

    <?= $form->field($model, 'date_final_exam')->textInput() ?>

    <?= $form->field($model, 'date_submission')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Generate'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
