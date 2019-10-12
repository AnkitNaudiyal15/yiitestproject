<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Daak;

class Status extends ActiveRecord
{

    public static function tableName()
    {
        $prefix = "e&Y_";
        return $prefix.'status';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDaak()
    {
        return $this->belongTo(Daak::className(), ['id' => 'status']);
    }
}
