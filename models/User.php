<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $isAdmin
 * @property string $photo
 *
 * @property Comment[] $comments
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['isAdmin'], 'integer'],
            [['name', 'email', 'password', 'photo'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'isAdmin' => 'Is Admin',
            'photo' => 'Photo',
        ];
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return User::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }


    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }


    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public static function findByUsername($username)
    {
        return User::find()->where(['name' => $username])->one();
    }

    public static function findByEmail($email)
    {
        return User::find()->where(['email' => $email])->one();
    }

    public function validatePassword($password)
    {
        return ($this->password == $password) ? true : false;
    }

    public function create()
    {
        return $this->save(false);
    }
    public function getImage()
    {
        return $this->photo;
    }
}
