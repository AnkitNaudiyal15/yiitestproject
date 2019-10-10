<?php

namespace app\models;

use yii\db\ActiveRecord;

class Department extends ActiveRecord
{

    public static function tableName()
    {
        $prefix = "e&Y_";
        return $prefix.'departments';
    }
}
