<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class UserForm extends Model
{
    public $username;
    public $password;
    public $department;
    public $role;
    public $email;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password','department','role','email'], 'required'],
            // username is validated by validateUser()
            ['username', 'validateUser'],
            // email is validated by validateEmail()
            ['email', 'validateEmail'],
         ];
    }


    
    /**
     * Validates the User Department.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUser($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user && $user->username == $this->username ) {
                $this->addError($attribute, 'Username is already occupied please choose some other.');
            }
        }
    }




    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user && $user->user_email == $this->email ) {
                $this->addError($attribute, 'email already exist.');
            }
        }
    }
    
    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function createUser()
    {
        if ($this->validate()) {
            
            $user = new User;
            $user->username = $this->username;
            $user->password = $this->password;
            $user->user_email = $this->email;
            $user->user_type = $this->role;
            $user->user_department = $this->department;
            $user->authKey = 'sdsd'.rand(1,1000);
            $user->accessToken = 'sdsdwwdd'.rand(1,1000);
            $user->created_at = date('Y-m-d h:i:s');
            $user->updated_at = date('Y-m-d h:i:s');
            $user->save(false);

            return true;
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        if(!$this->_user){
            $this->_user = User::findOne(['user_email'=>$this->email]);
        }
             if($this->_user){
                $this->_user->id = $this->_user->getAttribute('id');
                $this->_user->username = $this->_user->getAttribute('username');
                $this->_user->password = $this->_user->getAttribute('password');
                $this->_user->authKey = $this->_user->getAttribute('authKey');
                $this->_user->accessToken = $this->_user->getAttribute('accessToken');
           
            }
            

        return $this->_user;
    }
}
