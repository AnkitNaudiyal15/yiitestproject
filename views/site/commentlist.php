<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\User;

?>
<div class="daaklist">

<?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        
    ]); ?>

         <?= $form->field($model, 'message')->textarea(['rows' => '6']) ?>
        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-9">
                <?= Html::submitButton('Post Comment', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
        <?= $form->field($model, 'daak')->hiddenInput(['value'=>$daak->id,])->label(false) ?>
        <?= $form->field($model, 'messageBy')->hiddenInput(['value'=>$login,])->label(false) ?>
    <?php ActiveForm::end(); ?>


<?= 
GridView::widget([
    'dataProvider' => $data,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'message',
        [
            'class' => 'yii\grid\DataColumn', 
            'label' => 'comment by',
            'format' => 'html',
            'value' => function ($data) {
               $commenter = User::findOne($data->message_by);
            return $commenter->username;
            },
         ],
      [

         'class' => 'yii\grid\DataColumn', 
         'label' => 'comment date',
         'format' => 'html',
         'value' => function ($data) {
             $data1= html_entity_decode($data->created_at);
         return $data1;
         },
      ],
      
   
    ],
        
        ]);

?>
</div>