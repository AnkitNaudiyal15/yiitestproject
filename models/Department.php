<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Daak;

class Department extends ActiveRecord
{

    public static function tableName()
    {
        $prefix = "e&Y_";
        return $prefix.'departments';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDaak()
    {
        return $this->belongTo(Daak::className(), ['id' => 'department_type']);
    }

}
