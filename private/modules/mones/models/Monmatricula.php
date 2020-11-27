<?php

namespace app\modules\mones\models;

use Yii;

/**
 * This is the model class for table "monmatricula".
 *
 * @property int $id
 * @property int $alumno
 * @property int $carrera
 * @property string $certificado
 * @property int $libro
 * @property int $folio
 *
 * @property Monalumno $alumno0
 * @property Moncarrera $carrera0
 */
class Monmatricula extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'monmatricula';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'alumno', 'carrera', 'libro', 'folio'], 'integer'],
            [['certificado'], 'safe'],
            [['id'], 'unique'],
            [['alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Monalumno::className(), 'targetAttribute' => ['alumno' => 'documento']],
            [['carrera'], 'exist', 'skipOnError' => true, 'targetClass' => Moncarrera::className(), 'targetAttribute' => ['carrera' => 'id']],
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
            'carrera' => 'Carrera',
            'certificado' => 'Certificado',
            'libro' => 'Libro',
            'folio' => 'Folio',
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
    public function getCarrera0()
    {
        return $this->hasOne(Moncarrera::className(), ['id' => 'carrera']);
    }
}
