<?php

use yii\grid\GridView;
use yii\helpers\Url;

?>
<div class="daaklist">

<?= 
GridView::widget([
    'dataProvider' => $data,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'subject',
        [
            'class' => 'yii\grid\DataColumn', 
            'label' => 'Content',
            'format' => 'html',
            'value' => function ($data) {
                $data1= html_entity_decode($data->content);
            return $data1;
            },
         ],
      
        [
            'class' => 'yii\grid\DataColumn', 
            'label' => 'Attachment',
            'format' => 'html',
            'value' => function ($data) {
               return '<a  href="/web/'.$data->file.'" target="_blank">Attachment</a>' ;
            },
         ],

        [
            'class' => 'yii\grid\DataColumn', 
            'label' => 'Department',
            'value' => function ($data) {
               return $data->department->department ;
            },
         ],
         [
            'class' => 'yii\grid\DataColumn', 
            'label' => 'Role',
            'value' => function ($data) {
               return $data->role->role ;
            },
         ],
         [
            'class' => 'yii\grid\DataColumn', 
            'label' => 'Comments',
            'format' => 'html',
            'value' => function ($data) {
               return '<a href="site/status/'.Url::toRoute(['site/comment', 'id' => $data->id]).'">Comments</a>' ;

            },
         ],

         [
            'class' => 'yii\grid\DataColumn', 
            'label' => 'Accept/Reject',
            'format' => 'html',
            'value' => function ($data) {
               return '<a href="site/status/'.Url::toRoute(['site/status', 'id' => $data->id]).'">Update Staus</a>' ;
            },
         ],

   
        
    ],
        
        ]);

?>
</div>