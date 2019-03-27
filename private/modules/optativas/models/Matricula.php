<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "matricula".
 *
 * @property int $id
 * @property string $fecha
 * @property int $alumno
 * @property int $comision
 * @property int $estadomatricula
 *
 * @property Calificacion[] $calificacions
 * @property Inasistencia[] $inasistencias
 * @property Comision $comision0
 * @property Alumno $alumno0
 * @property Estadomatricula $estadomatricula0
 * @property Seguimiento[] $seguimientos
 */
class Matricula extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'matricula';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'alumno', 'comision', 'estadomatricula'], 'required'],
            [['fecha'], 'safe'],
            [['alumno', 'comision', 'estadomatricula'], 'integer'],
            [['comision'], 'exist', 'skipOnError' => true, 'targetClass' => Comision::className(), 'targetAttribute' => ['comision' => 'id']],
            [['alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumno::className(), 'targetAttribute' => ['alumno' => 'id']],
            [['estadomatricula'], 'exist', 'skipOnError' => true, 'targetClass' => Estadomatricula::className(), 'targetAttribute' => ['estadomatricula' => 'id']],
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
            'alumno' => 'Alumno',
            'comision' => 'Comision',
            'estadomatricula' => 'Estadomatricula',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacions()
    {
        return $this->hasMany(Calificacion::className(), ['matricula' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInasistencias()
    {
        return $this->hasMany(Inasistencia::className(), ['matricula' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComision0()
    {
        return $this->hasOne(Comision::className(), ['id' => 'comision']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno0()
    {
        return $this->hasOne(Alumno::className(), ['id' => 'alumno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadomatricula0()
    {
        return $this->hasOne(Estadomatricula::className(), ['id' => 'estadomatricula']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeguimientos()
    {
        return $this->hasMany(Seguimiento::className(), ['matricula' => 'id']);
    }
}
