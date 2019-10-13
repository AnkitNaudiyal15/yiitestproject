<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Department;
use app\models\Role;
use app\models\Status;

class Daak extends ActiveRecord
{
    public $status;
    public $daakSubject;
    public $daakId;
    
    public static function tableName()
    {
        $prefix = "e&Y_";
        return $prefix.'daak';
    }


     /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['status', 'daakSubject','daakId'], 'required'],
            [['status'], 'safe'],
           ];
    }


    /**
     * create daak .
     * @return bool daak created successfully
     */
    public function changeStatus()
    {
        if ($this->validate()) {
            return true;
        }
        return false;
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
