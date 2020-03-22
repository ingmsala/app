<?php

namespace app\modules\curriculares\models;

use app\models\Turno;
use Yii;

/**
 * This is the model class for table "admisionsociocom".
 *
 * @property int $id
 * @property int $alumno
 * @property int $curso
 * @property int $aniolectivo
 * @property int $turno
 *
 * @property Turno $turno0
 */
class Admisionsociocom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admisionsociocom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alumno', 'curso', 'aniolectivo'], 'required'],
            [['alumno', 'curso', 'aniolectivo', 'turno'], 'integer'],
            [['alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumno::className(), 'targetAttribute' => ['alumno' => 'id']],
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
            'alumno' => 'Alumno',
            'curso' => 'Curso',
            'aniolectivo' => 'Aniolectivo',
            'turno' => 'Turno',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurno0()
    {
        return $this->hasOne(Turno::className(), ['id' => 'turno']);
    }
    public function getAlumno0()
    {
        return $this->hasOne(Alumno::className(), ['id' => 'alumno']);
    }
    public function getAniolectivo0()
    {
        return $this->hasOne(Aniolectivo::className(), ['id' => 'aniolectivo']);
    }
}
