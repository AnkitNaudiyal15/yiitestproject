<?php
// _list_item.php
use yii\helpers\Html;
use yii\helpers\Url;
?>
  
    <?= Html::encode($model->content); ?>
    <?= Html::encode($model->department->department); ?>
    <?= Html::encode($model->role->role); ?>
    <?= Html::encode($model->status); ?>
