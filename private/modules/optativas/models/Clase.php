<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "clase".
 *
 * @property int $id
 * @property string $fecha
 * @property string $tema
 * @property int $tipoclase
 * @property int $comision
 *
 * @property Inasistencia[] $inasistencias
 */
class Clase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clase';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'tema', 'tipoclase', 'comision'], 'required'],
            [['fecha'], 'safe'],
            [['tipoclase', 'comision'], 'integer'],
            [['tema'], 'string', 'max' => 200],
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
            'tema' => 'Tema',
            'tipoclase' => 'Tipo de clase',
            'comision' => 'Comision',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInasistencias()
    {
        return $this->hasMany(Inasistencia::className(), ['clase' => 'id']);
    }

    public function getComision0()
    {
        return $this->hasOne(Comision::className(), ['id' => 'comision']);
    }

    public function getTipoclase0()
    {
        return $this->hasOne(Tipoclase::className(), ['id' => 'tipoclase']);
    }
}
