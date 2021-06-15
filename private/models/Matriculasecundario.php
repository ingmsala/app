<?php

namespace app\models;

use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\Aniolectivo;
use Yii;

/**
 * This is the model class for table "matriculasecundario".
 *
 * @property int $id
 * @property int $alumno
 * @property int $aniolectivo
 * @property int $division
 *
 * @property Alumno $alumno0
 * @property Aniolectivo $aniolectivo0
 * @property Division $division0
 */
class Matriculasecundario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'matriculasecundario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alumno', 'aniolectivo', 'division'], 'required'],
            [['alumno', 'aniolectivo', 'division'], 'integer'],
            [['alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumno::className(), 'targetAttribute' => ['alumno' => 'id']],
            [['aniolectivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aniolectivo::className(), 'targetAttribute' => ['aniolectivo' => 'id']],
            [['division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division' => 'id']],
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
            'aniolectivo' => 'Aniolectivo',
            'division' => 'Division',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivision0()
    {
        return $this->hasOne(Division::className(), ['id' => 'division']);
    }
}
