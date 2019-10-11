<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Daak System';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Daak management system</h1>
        <p class="lead">This is the demo app for the  e&y </p>
        <p><a class="btn btn-lg btn-success" href='<?= Url::to(['/site/login']); ?>'>Login from here</a></p>
    </div>
</div>
