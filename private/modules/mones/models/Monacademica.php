<?php

namespace app\modules\mones\models;

use Yii;

/**
 * This is the model class for table "monacademica".
 *
 * @property int $id
 * @property string $curso
 * @property string $condicion
 * @property string $nota
 * @property int $alumno
 * @property string $materia
 * @property string $fecha
 *
 * @property Monalumno $alumno0
 * @property Monmateria $materia0
 */
class Monacademica extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'monacademica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'curso', 'condicion', 'alumno', 'materia', 'fecha'], 'required'],
            [['id', 'alumno'], 'integer'],
            [['fecha'], 'safe'],
            [['curso', 'condicion', 'nota'], 'string', 'max' => 4],
            [['materia'], 'string', 'max' => 7],
            [['id'], 'unique'],
            [['alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Monalumno::className(), 'targetAttribute' => ['alumno' => 'documento']],
            [['materia'], 'exist', 'skipOnError' => true, 'targetClass' => Monmateria::className(), 'targetAttribute' => ['materia' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'curso' => 'Curso',
            'condicion' => 'Condicion',
            'nota' => 'Nota',
            'alumno' => 'Alumno',
            'materia' => 'Materia',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno0()
    {
        return $this->hasOne(Monalumno::className(), ['documento' => 'alumno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMateria0()
    {
        return $this->hasOne(Monmateria::className(), ['id' => 'materia']);
    }
}
