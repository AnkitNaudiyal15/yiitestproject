<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;

$this->title = 'Create Daak';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create a daak:</p>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data','id' => 'login-form'],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label']
        ],
        
    ]); ?>

        <?= $form->field($model, 'subject')->textInput(['autofocus' => true]) ?>
      
        <?php echo $form->field($model, 'content')->widget(CKEditor::className(), [
        ]); ?>

        <?= $form->field($model, 'file')->fileInput() ?>

        <?= $form->field($model, 'department')->dropDownList(
            ArrayHelper::map($departments, 'id', 'department')) 
        ?>

        <?= $form->field($model, 'role')->dropDownList(
            ArrayHelper::map($roles, 'id', 'role')) 
        ?>
        
        <?= $form->field($model, 'status')->dropDownList(
            ArrayHelper::map($status, 'id', 'status_type')) 
        ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Create Daak', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
