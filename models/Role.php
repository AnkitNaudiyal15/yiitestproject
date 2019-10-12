<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Daak;

class Role extends ActiveRecord
{

    public static function tableName()
    {
        $prefix = "e&Y_";
        return $prefix.'roles';
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getDaak()
    {
        return $this->belongTo(Daak::className(), ['id' => 'user_type']);
    }
}
