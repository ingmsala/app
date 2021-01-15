<?php

namespace app\modules\edh\models;

use Yii;

use app\models\Division;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\Aniolectivo;


/**
 * This is the model class for table "matriculaedh".
 *
 * @property int $id
 * @property int $alumno
 * @property int $division
 * @property int $aniolectivo
 *
 * @property Caso[] $casos
 * @property Alumno $alumno0
 * @property Aniolectivo $aniolectivo0
 * @property Division $division0
 */
class Matriculaedh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'matriculaedh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alumno', 'division', 'aniolectivo'], 'required'],
            [['alumno', 'division', 'aniolectivo'], 'integer'],
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
            'division' => 'Division',
            'aniolectivo' => 'Aniolectivo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCasos()
    {
        return $this->hasMany(Caso::className(), ['matricula' => 'id']);
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
