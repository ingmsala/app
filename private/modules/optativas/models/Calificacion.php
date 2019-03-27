<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "calificacion".
 *
 * @property int $id
 * @property string $fecha
 * @property int $matricula
 * @property int $calificacion
 * @property int $estadocalificacion
 *
 * @property Matricula $matricula0
 */
class Calificacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calificacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'matricula', 'estadocalificacion'], 'required'],
            [['fecha'], 'safe'],
            [['matricula', 'calificacion', 'estadocalificacion'], 'integer'],
            [['matricula'], 'exist', 'skipOnError' => true, 'targetClass' => Matricula::className(), 'targetAttribute' => ['matricula' => 'id']],
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
            'matricula' => 'Matricula',
            'calificacion' => 'Calificacion',
            'estadocalificacion' => 'Estadocalificacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatricula0()
    {
        return $this->hasOne(Matricula::className(), ['id' => 'matricula']);
    }
}
