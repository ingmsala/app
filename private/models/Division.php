<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "division".
 *
 * @property int $id
 * @property string $nombre
 * @property int $turno
 * @property int $propuesta
 *
 * @property Catedra[] $catedras
 * @property Turno $turno0
 * @property Propuesta $propuesta0
 * @property Funcion[] $funcions
 */
class Division extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'division';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'propuesta'], 'required'],
            [['turno', 'propuesta'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['turno'], 'exist', 'skipOnError' => true, 'targetClass' => Turno::className(), 'targetAttribute' => ['turno' => 'id']],
            [['propuesta'], 'exist', 'skipOnError' => true, 'targetClass' => Propuesta::className(), 'targetAttribute' => ['propuesta' => 'id']],
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
            'turno' => 'Turno',
            'propuesta' => 'Propuesta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatedras()
    {
        return $this->hasMany(Catedra::className(), ['division' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurno0()
    {
        return $this->hasOne(Turno::className(), ['id' => 'turno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropuesta0()
    {
        return $this->hasOne(Propuesta::className(), ['id' => 'propuesta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFuncions()
    {
        return $this->hasMany(Funcion::className(), ['division' => 'id']);
    }
}
