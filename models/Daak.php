<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Department;
use app\models\Role;
use app\models\Status;

class Daak extends ActiveRecord
{

    public static function tableName()
    {
        $prefix = "e&Y_";
        return $prefix.'daak';
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id'=> 'department_type']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id'=> 'user_type']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(Status::className(), ['id'=> 'status']);
    }

}
