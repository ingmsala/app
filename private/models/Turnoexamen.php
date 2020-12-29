<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "turnoexamen".
 *
 * @property int $id
 * @property string $nombre
 * @property string $desde
 * @property string $hasta
 * @property int $tipoturno
 * @property int $activo
 *
 * @property Mesaexamen[] $mesaexamens
 */
class Turnoexamen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'turnoexamen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'desde', 'hasta', 'tipoturno', 'activo'], 'required'],
            [['desde', 'hasta'], 'safe'],
            [['tipoturno', 'activo'], 'integer'],
            [['nombre'], 'string', 'max' => 200],
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
            'desde' => 'Desde',
            'hasta' => 'Hasta',
            'tipoturno' => 'Tipoturno',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMesaexamens()
    {
        return $this->hasMany(Mesaexamen::className(), ['turnoexamen' => 'id']);
    }
    public function getTipoturno0()
    {
        return $this->hasOne(Tipoparte::className(), ['id' => 'tipoturno']);
    }
}
