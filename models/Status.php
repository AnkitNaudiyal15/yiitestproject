<?php

namespace app\models;

use yii\db\ActiveRecord;

class Status extends ActiveRecord
{

    public static function tableName()
    {
        $prefix = "e&Y_";
        return $prefix.'status';
    }

}
