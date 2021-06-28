<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;

use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property integer $role
 * @property integer $activate
 */


class User extends \yii\db\ActiveRecord  implements IdentityInterface {

/**
 * @inheritdoc
 */

    const SCENARIO_CHANGEPASS = 'cambiarpass';
    const SCENARIO_RESETPASS = 'resetpass';
    public $old_password;
    public $new_password;
    public $repeat_password;
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHANGEPASS] = ['username', 'old_password', 'new_password', 'repeat_password'];
        $scenarios[self::SCENARIO_RESETPASS] = ['username', 'new_password', 'repeat_password'];
        return $scenarios;
    }

public static function tableName() {
    return 'user';
}

/**
 * @inheritdoc
 */
public function rules() {
    return [
        [['username', 'role','activate'], 'required'],
        ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Ya existe el usuario.'],
        [['username'], 'string', 'max' => 100],
        [['password'], 'string', 'max' => 60],
        [['authKey'], 'string', 'max' => 32],
        [['old_password', 'new_password', 'repeat_password'], 'required', 'on'=>self::SCENARIO_CHANGEPASS],
        [['username', 'new_password', 'repeat_password'], 'required', 'on'=>self::SCENARIO_RESETPASS],
        ['repeat_password', 'compare', 'compareAttribute'=>'new_password', 'message' => 'Las contraseñas no coinciden', 'on'=>self::SCENARIO_CHANGEPASS],
        ['repeat_password', 'compare', 'compareAttribute'=>'new_password', 'message' => 'Las contraseñas no coinciden', 'on'=>self::SCENARIO_RESETPASS],
        ['old_password', 'findPasswords', 'on' => self::SCENARIO_CHANGEPASS],
    ];
}

public function findPasswords($attribute, $params, $validator)
    {
        $user = User::find()
        ->where(['username' => Yii::$app->user->identity->username])->one();
        if (!Yii::$app->security->validatePassword($this->old_password, $user->password))
            $this->addError($attribute, 'Las contraseña anterior es incorrecta');
    }

/**
 * @inheritdoc
 */
public function attributeLabels() {
    return [
        'id' => 'ID',
        'username' => 'Usuario',
        'email' => 'Email',
        'password' => 'Contraseña',
        'authKey' => 'Auth Key',
        'role' => 'Tipo de usuario',
        'activate' => 'Activo',
        'old_password' => 'Contraseña anterior', 
        'new_password' => 'Nueva contraseña', 
        'repeat_password' => 'Repetir contraseña',
    ];
}

/** INCLUDE USER LOGIN VALIDATION FUNCTIONS* */

/**
 * @inheritdoc
 */
public static function findIdentity($id) {
    return static::findOne($id);
}

/**
 * @inheritdoc
 */
/* modified */
public static function findIdentityByAccessToken($token, $type = null) {
    return static::findOne(['access_token' => $token]);
}

/* removed
  public static function findIdentityByAccessToken($token)
  {
  throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
  }
 */

/**
 * Finds user by username
 *
 * @param  string      $username
 * @return static|null
 */
public static function findByUsername($username) {
    return static::find()->where(['username' => $username])->andWhere(['<', 'activate', 2])->one();
}

/**
 * Finds user by password reset token
 *
 * @param  string      $token password reset token
 * @return static|null
 */
public static function findByPasswordResetToken($token) {
    $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
    $parts = explode('_', $token);
    $timestamp = (int) end($parts);
    if ($timestamp + $expire < time()) {
        // token expired
        return null;
    }

    return static::findOne([
                'password_reset_token' => $token
    ]);
}

/**
 * @inheritdoc
 */
public function getId() {
    return $this->getPrimaryKey();
}

/**
 * @inheritdoc
 */


public function getAuthKey() {
    return $this->authKey;
}

/**
 * @inheritdoc
 */
public function validateAuthKey($authKey) {
    return $this->getAuthKey() === $authKey;
}

/**
 * Validates password
 *
 * @param  string  $password password to validate
 * @return boolean if password provided is valid for current user
 */
public function validatePassword($password) {
    return Yii::$app->security->validatePassword($password, $this->password);
}

/**
 * Generates password hash from password and sets it to the model
 *
 * @param string $password
 */
public function setPassword($password) {
    $this->password = Yii::$app->security->generatePasswordHash($password);
}

/**
 * Generates "remember me" authentication key
 */
public function generateAuthKey() {
    $this->authKey = Yii::$app->security->generateRandomString();
}
/**
 * Generates new password reset token
 */
public function generatePasswordResetToken() {
    $this->password_reset_token = Security::generateRandomKey() . '_' . time();
}

/**
 * Removes password reset token
 */
public function removePasswordResetToken() {
    $this->password_reset_token = null;
}

 public function getRole0()
    {
        return $this->hasOne(Role::className(), ['id' => 'role']);
    }

     public function getAgente0()
    {
        return $this->hasOne(Agente::className(), ['mail' => 'username']);
    }

    public function getRolexusers()
    {
        return $this->hasMany(Rolexuser::className(), ['user' => 'id']);
    }

    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['id' => 'role'])->via('rolexusers');
    }


}