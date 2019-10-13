<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Department;
use app\models\Role;
use app\models\Status;

class Comment extends ActiveRecord
{
 
    public static function tableName()
    {
        $prefix = "e&Y_";
        return $prefix.'comments';
    }


     /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['message','daak'], 'required'],
             ];
    }


    /**
     * create daak .
     * @return bool daak created successfully
     */
    public function comments()
    {
        if ($this->validate()) {
            return true;
        }
        return false;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommenter()
    {
        return $this->hasOne(User::className(), ['id'=> 'message_by']);
    }
    

}
