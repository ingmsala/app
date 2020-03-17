<?php

namespace app\modules\curriculares\models;

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
            [['tipoclase', 'comision'], 'required'],
            [['fecha', 'hora', 'horafin'], 'safe'],
            [['horascatedra'], 'number'],
            [['tipoclase', 'comision'], 'integer'],
            [['tema'], 'string', 'max' => 200],
            [['comision'], 'exist', 'skipOnError' => true, 'targetClass' => Comision::className(), 'targetAttribute' => ['comision' => 'id']], 
            [['tipoclase'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoclase::className(), 'targetAttribute' => ['tipoclase' => 'id']], 
            [['tipoasistencia'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoclase::className(), 'targetAttribute' => ['tipoasistencia' => 'id']], 

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
            'hora' => 'Hora de Inicio',
            'horafin' => 'Hora de fin',
            'fechaconf' => 'Confirmación de Fecha',
            'tipoasistencia' => 'Tipo de asistencia',
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
    public function getTipoasistencia0()
    {
        return $this->hasOne(Tipoasistencia::className(), ['id' => 'tipoasistencia']);
    }
}
