<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "horarioexamen".
 *
 * @property int $id
 * @property int $catedra
 * @property int $hora
 * @property int $tipo
 * @property int $anioxtrimestral
 * @property string $fecha
 * @property int $cambiada
 *
 * @property Catedra $catedra0
 * @property Anioxtrimestral $anioxtrimestral0
 * @property Tipoparte $tipo0
 * @property Hora $hora0
 */
class Horarioexamen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horarioexamen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catedra', 'hora', 'tipo', 'anioxtrimestral', 'fecha'], 'required'],
            [['catedra', 'hora', 'tipo', 'anioxtrimestral', 'cambiada'], 'integer'],
            [['fecha'], 'safe'],
            [['catedra'], 'exist', 'skipOnError' => true, 'targetClass' => Catedra::className(), 'targetAttribute' => ['catedra' => 'id']],
            [['anioxtrimestral'], 'exist', 'skipOnError' => true, 'targetClass' => Anioxtrimestral::className(), 'targetAttribute' => ['anioxtrimestral' => 'id']],
            [['tipo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoparte::className(), 'targetAttribute' => ['tipo' => 'id']],
            [['hora'], 'exist', 'skipOnError' => true, 'targetClass' => Hora::className(), 'targetAttribute' => ['hora' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catedra' => 'Catedra',
            'hora' => 'Hora',
            'tipo' => 'Tipo',
            'anioxtrimestral' => 'Anioxtrimestral',
            'fecha' => 'Fecha',
            'cambiada' => 'Cambiada',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatedra0()
    {
        return $this->hasOne(Catedra::className(), ['id' => 'catedra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnioxtrimestral0()
    {
        return $this->hasOne(Anioxtrimestral::className(), ['id' => 'anioxtrimestral']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo0()
    {
        return $this->hasOne(Tipoparte::className(), ['id' => 'tipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHora0()
    {
        return $this->hasOne(Hora::className(), ['id' => 'hora']);
    }
}
