<?php

use yii\grid\GridView;
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
            'label' => 'Status',
            'value' => function ($data) {
               return $data->state->status_type ;
            },
         ],

        ['class' => 'yii\grid\ActionColumn'],
        
    ],
        
        ]);

?>
</div>