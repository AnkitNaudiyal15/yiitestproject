<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Accept/Reject Daak';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please change accepte or reject the daak </p>

    <?php $form = ActiveForm::begin([
        'id' => 'luserCreated-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

        <?= $form->field($data, 'daakSubject')->textInput(['readonly' => true,'value' => $data->subject]) ?>
        <?= $form->field($data, 'daakId')->hiddenInput(['readonly' => true,'value' => $data->id])->label(false) ?>

        <?= $form->field($data, 'status')->dropDownList(
            ArrayHelper::map($status, 'id', 'status_type')) 
        ?>
           
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('update status', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
