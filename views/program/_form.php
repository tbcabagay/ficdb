<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Program */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="program-form">

    <?php $form = ActiveForm::begin([
        'id' => 'app-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl' =>  ($model->isNewRecord) ? ['validate-create'] : ['validate-update', 'id' => $model->id],
        'options' => [
            'autocomplete' => 'off',
        ],
    ]); ?>

    <?= $form->field($model, 'office_id')->widget(Select2::className(), [
        'data' => $offices,
        'options' => ['placeholder' => '- Select -'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
