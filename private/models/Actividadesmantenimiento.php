<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividadesmantenimiento".
 *
 * @property int $id
 * @property string $fecha
 * @property int $usuario
 * @property int $tareamantenimiento
 * @property string $observaciones
 *
 * @property User $usuario0
 * @property Tareamantenimiento $tareamantenimiento0
 */
class Actividadesmantenimiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actividadesmantenimiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'usuario', 'tareamantenimiento'], 'required'],
            [['fecha'], 'safe'],
            [['usuario', 'tareamantenimiento'], 'integer'],
            [['observaciones'], 'string'],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario' => 'id']],
            [['tareamantenimiento'], 'exist', 'skipOnError' => true, 'targetClass' => Tareamantenimiento::className(), 'targetAttribute' => ['tareamantenimiento' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'usuario' => 'Usuario',
            'tareamantenimiento' => 'Tareamantenimiento',
            'observaciones' => 'Observaciones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario0()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTareamantenimiento0()
    {
        return $this->hasOne(Tareamantenimiento::className(), ['id' => 'tareamantenimiento']);
    }
}
