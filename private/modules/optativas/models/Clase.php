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
 * @property double  $horascatedra
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
            [['fecha', 'tipoclase', 'comision'], 'required'],
            [['fecha', 'hora'], 'safe'],
            [['horascatedra'], 'number'],
            [['tipoclase', 'comision'], 'integer'],
            [['tema'], 'string', 'max' => 200],
            [['comision'], 'exist', 'skipOnError' => true, 'targetClass' => Comision::className(), 'targetAttribute' => ['comision' => 'id']], 
            [['tipoclase'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoclase::className(), 'targetAttribute' => ['tipoclase' => 'id']], 

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
            'horascatedra' => 'Horas Cátedra',
            'hora' => 'Horario',
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
