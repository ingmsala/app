<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "funcion".
 *
 * @property int $id
 * @property string $nombre
 * @property int $cargo
 * @property int $horas
 * @property int $docente
 * @property int $revista
 * @property int $division
 *
 * @property Revista $revista0
 * @property Cargo $cargo0
 * @property Agente $agente0
 * @property Division $division0
 */
class Funcion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'funcion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cargo', 'horas', 'agente', 'revista'], 'required'],
            [['id', 'cargo', 'horas', 'agente', 'revista', 'division'], 'integer'],
            [['nombre'], 'string', 'max' => 150],
            [['id'], 'unique'],
            [['revista'], 'exist', 'skipOnError' => true, 'targetClass' => Revista::className(), 'targetAttribute' => ['revista' => 'id']],
            [['cargo'], 'exist', 'skipOnError' => true, 'targetClass' => Cargo::className(), 'targetAttribute' => ['cargo' => 'id']],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division' => 'id']],
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
            'cargo' => 'Cargo',
            'horas' => 'Horas',
            'agente' => 'Agente',
            'revista' => 'Revista',
            'division' => 'Division',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRevista0()
    {
        return $this->hasOne(Revista::className(), ['id' => 'revista']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargo0()
    {
        return $this->hasOne(Cargo::className(), ['id' => 'cargo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgente0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'agente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivision0()
    {
        return $this->hasOne(Division::className(), ['id' => 'division']);
    }
}
