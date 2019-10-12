<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class DaakForm extends Model
{
    public $subject;
    public $content;
    public $department;
    public $role;
    public $file;
    public $status;

    

    /**
     * @return array the validation rules.
     */
    public function rules()
    {


        return [
            // username and password are both required
            [['subject', 'content','department','role','status'], 'required'],

            // verifyCode needs to be entered correctly
            [['file'], 'file', 'extensions' => 'pdf','maxSize' => 512000, 'tooBig' => 'Limit is 500KB'],
        ];
    }
    
    /**
     * create daak .
     * @return bool daak created successfully
     */
    public function createDaak()
    {
        if ($this->validate()) {
            return true;
        }
        return false;
    }

}
