<?php

namespace app\modules\curriculares\models;

use Yii;

/**
 * This is the model class for table "seguimiento".
 *
 * @property int $id
 * @property int $matricula
 * @property string $fecha
 * @property string $descripcion
 *
 * @property Matricula $matricula0
 */
class Seguimiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguimiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['matricula', 'fecha', 'tiposeguimiento', 'trimestre'], 'required'],
            [['matricula', 'trimestre'], 'integer'],
            [['matricula', 'tiposeguimiento', 'estadoseguimiento'], 'integer'],
            [['descripcion'], 'safe'],
            [['fecha'], 'safe'],
            [['matricula'], 'exist', 'skipOnError' => true, 'targetClass' => Matricula::className(), 'targetAttribute' => ['matricula' => 'id']],
            [['tiposeguimiento'], 'exist', 'skipOnError' => true, 'targetClass' => Tiposeguimiento::className(), 'targetAttribute' => ['tiposeguimiento' => 'id']], 
            [['estadoseguimiento'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoseguimiento::className(), 'targetAttribute' => ['estadoseguimiento' => 'id']], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'matricula' => 'Matricula',
            'fecha' => 'Fecha',
            'descripcion' => 'Descripcion',
            'tiposeguimiento' => 'Tipo de seguimiento', 
            'estadoseguimiento' => 'Estado de seguimiento', 
            'trimestre' => 'Trimestre', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatricula0()
    {
        return $this->hasOne(Matricula::className(), ['id' => 'matricula']);
    }

     /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getTiposeguimiento0() 
   { 
       return $this->hasOne(Tiposeguimiento::className(), ['id' => 'tiposeguimiento']); 
   } 
 
   /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getEstadoseguimiento0() 
   { 
       return $this->hasOne(Estadoseguimiento::className(), ['id' => 'estadoseguimiento']); 
   } 
}
