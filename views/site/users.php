<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\Department;
use app\models\Role;
use yii\helpers\ArrayHelper;

$this->title = 'Create User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create user:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'luserCreated-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'email')->input('email') ?>
        <?= $form->field($model, 'department')->dropDownList(
            ArrayHelper::map(Department::find()->all(), 'id', 'department')) 
        ?>
               <?= $form->field($model, 'role')->dropDownList(
            ArrayHelper::map(Role::find()->all(), 'id', 'role')) 
        ?>
 
        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-9">{image}</div><div class="col-lg-9">{input}</div></div>',
                    ]) 
        ?>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('userCreated', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
