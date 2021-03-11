<?php

namespace app\modules\horariogenerico\models;

use app\models\Hora;
use app\models\Semana;
use app\models\Turno;
use Yii;

/**
 * This is the model class for table "horareloj".
 *
 * @property int $id
 * @property int $hora
 * @property int $anio
 * @property int $turno
 * @property int $semana
 * @property string $inicio
 * @property string $fin
 *
 * @property Hora $hora0
 * @property Semana $semana0
 * @property Turno $turno0
 * @property Horariogeneric[] $horariogenerics
 */
class Horareloj extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horareloj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hora', 'anio', 'turno', 'semana', 'inicio', 'fin'], 'required'],
            [['hora', 'anio', 'turno', 'semana'], 'integer'],

            [['hora', 'anio', 'turno', 'semana'], 'unique', 'targetAttribute' => ['hora', 'anio', 'turno', 'semana']],

            [['inicio', 'fin'], 'safe'],
            [['hora'], 'exist', 'skipOnError' => true, 'targetClass' => Hora::className(), 'targetAttribute' => ['hora' => 'id']],
            [['semana'], 'exist', 'skipOnError' => true, 'targetClass' => Semana::className(), 'targetAttribute' => ['semana' => 'id']],
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
            'hora' => 'Horas',
            'anio' => 'Año',
            'turno' => 'Turno',
            'semana' => 'Semana',
            'inicio' => 'Inicio',
            'fin' => 'Fin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHora0()
    {
        return $this->hasOne(Hora::className(), ['id' => 'hora']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemana0()
    {
        return $this->hasOne(Semana::className(), ['id' => 'semana']);
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
    public function getHorariogenerics()
    {
        return $this->hasMany(Horariogeneric::className(), ['horareloj' => 'id']);
    }
}
