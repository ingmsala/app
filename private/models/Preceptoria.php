<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preceptoria".
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property int $turno
 *
 * @property Division[] $divisions
 * @property Parte[] $partes
 * @property Turno $turno0
 */
class Preceptoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'preceptoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'turno'], 'required'],
            [['turno', 'pisos'], 'integer'],
            [['nombre'], 'string', 'max' => 20],
            [['descripcion'], 'string', 'max' => 50],
            [['turno'], 'exist', 'skipOnError' => true, 'targetClass' => Turno::className(), 'targetAttribute' => ['turno' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'turno' => 'Turno',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivisions()
    {
        return $this->hasMany(Division::className(), ['preceptoria' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartes()
    {
        return $this->hasMany(Parte::className(), ['preceptoria' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurno0()
    {
        return $this->hasOne(Turno::className(), ['id' => 'turno']);
    }
}
