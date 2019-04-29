<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "novedadesparte".
 *
 * @property int $id
 * @property int $tiponovedad
 * @property int $parte
 * @property string $descripcion
 * @property int $estadonovedad
 *
 * @property Estadonovedad $estadonovedad0
 * @property Tiponovedad $tiponovedad0
 * @property Parte $parte0
 */
class Novedadesparte extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'novedadesparte';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tiponovedad', 'parte', 'estadonovedad'], 'required'],
            [['tiponovedad', 'parte', 'estadonovedad', 'docente'], 'integer'],
            [['descripcion'], 'string'],
            [['estadonovedad'], 'exist', 'skipOnError' => true, 'targetClass' => Estadonovedad::className(), 'targetAttribute' => ['estadonovedad' => 'id']],
            [['tiponovedad'], 'exist', 'skipOnError' => true, 'targetClass' => Tiponovedad::className(), 'targetAttribute' => ['tiponovedad' => 'id']],
            [['parte'], 'exist', 'skipOnError' => true, 'targetClass' => Parte::className(), 'targetAttribute' => ['parte' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tiponovedad' => 'Tipo de novedad',
            'parte' => 'Parte',
            'descripcion' => 'Descripción',
            'estadonovedad' => 'Estado de novedad',
            'docente' => 'Preceptor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadonovedad0()
    {
        return $this->hasOne(Estadonovedad::className(), ['id' => 'estadonovedad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiponovedad0()
    {
        return $this->hasOne(Tiponovedad::className(), ['id' => 'tiponovedad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParte0()
    {
        return $this->hasOne(Parte::className(), ['id' => 'parte']);
    }

    public function getDocente0()
    {
        return $this->hasOne(Docente::className(), ['id' => 'docente']);
    }
}