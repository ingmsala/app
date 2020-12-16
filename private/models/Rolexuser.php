<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rolexuser".
 *
 * @property int $id
 * @property int $user
 * @property int $role
 * @property string $subrole
 *
 * @property Role $role0
 * @property User $user0
 */
class Rolexuser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rolexuser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'role'], 'required'],
            [['user', 'role'], 'integer'],
            [['subrole'], 'string', 'max' => 50],
            [['role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role' => 'id']],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'role' => 'Role',
            'subrole' => 'Subrole',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole0()
    {
        return $this->hasOne(Role::className(), ['id' => 'role']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }
}
