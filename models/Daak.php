<?php

namespace app\models;

use yii\db\ActiveRecord;

class Daak extends ActiveRecord
{

    public static function tableName()
    {
        $prefix = "e&Y_";
        return $prefix.'daak';
    }
}
