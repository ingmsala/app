<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "materia".
 *
 * @property int $id
 * @property string $nombre
 * @property int $cantHoras
 * @property int $curso
 * @property int $plan
 * @property Catedra[] $catedras 
 * @property Curso $curso0
 * @property Plan $plan0
 */
class Materia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'materia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'cantHoras', 'curso', 'plan'], 'required'],
            [['cantHoras'], 'integer'],
            [['nombre'], 'string', 'max' => 70],
            [['curso'], 'exist', 'skipOnError' => true, 'targetClass' => Curso::className(), 'targetAttribute' => ['curso' => 'id']],
            [['plan'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'cantHoras' => 'Cantidad de Horas',
            'curso' => 'Curso',
            'plan' => 'Plan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurso0()
    {
        return $this->hasOne(Curso::className(), ['id' => 'curso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan0()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan']);
    }

    /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getCatedras() 
   { 
       return $this->hasMany(Catedra::className(), ['materia' => 'id']); 
   }
}
