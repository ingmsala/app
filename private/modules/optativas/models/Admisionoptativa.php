<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "admisionoptativa".
 *
 * @property int $id
 * @property int $alumno
 * @property int $curso
 * @property int $aniolectivo
 *
 * @property Alumno $alumno0
 * @property Aniolectivo $aniolectivo0
 */
class Admisionoptativa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admisionoptativa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alumno', 'curso', 'aniolectivo'], 'required'],
            [['alumno', 'curso', 'aniolectivo'], 'integer'],
            [['alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumno::className(), 'targetAttribute' => ['alumno' => 'id']],
            [['aniolectivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aniolectivo::className(), 'targetAttribute' => ['aniolectivo' => 'id']],
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
        ];
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
    public function getAniolectivo0()
    {
        return $this->hasOne(Aniolectivo::className(), ['id' => 'aniolectivo']);
    }
}
