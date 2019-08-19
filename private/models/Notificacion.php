<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notificacion".
 *
 * @property int $id
 * @property int $user
 * @property int $cantidad
 * @property int $tiponotificacion
 * @property int $estado
 */
class Notificacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notificacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user', 'cantidad', 'tiponotificacion', 'estado'], 'required'],
            [['id', 'user', 'cantidad', 'tiponotificacion', 'estado'], 'integer'],
            [['id'], 'unique'],
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
            'cantidad' => 'Cantidad',
            'tiponotificacion' => 'Tiponotificacion',
            'estado' => 'Estado',
        ];
    }

    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }
}
