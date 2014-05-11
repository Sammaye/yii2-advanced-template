<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $model->getIsNewRecord() ? 'Create Subject' : 'Update ' . $model->caption;

echo Html::tag('h1', $this->title);

$form = ActiveForm::begin(['enableClientValidation' => false]);
echo $form->errorSummary($model);
echo $form->field($model, 'caption');
echo $form->field($model, 'parent');
echo Html::submitButton(
	$model->getIsNewRecord() ? 'Create Subject' : 'Update ' . $model->caption,
	['class' => 'btn btn-success']
);
$form->end();