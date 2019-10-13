<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Comment;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        $prefix = "e&Y_";
        return $prefix.'users';
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (static::findOne($id) as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);

    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function userDepartment()
    {
        return $this->user_department;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    /**
     * Validates user department
     *
     * @param string $userDepartment department to validate
     * @return bool if department provided is valid for current user
     */
    public function validateUserDepartment($department)
    {
       // echo $this->user_department;
        //echo $department;
        //die('jj');
        return $this->user_department === $department;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->belongTo(Comment::className(), ['id' => 'message_by']);
    }

}
