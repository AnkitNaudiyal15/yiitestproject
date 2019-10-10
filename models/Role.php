<?php

namespace app\models;

use yii\db\ActiveRecord;

class Role extends ActiveRecord
{

    public static function tableName()
    {
        $prefix = "e&Y_";
        return $prefix.'roles';
    }
}
