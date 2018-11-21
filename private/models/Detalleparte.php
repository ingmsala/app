<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalleparte".
 *
 * @property int $id
 * @property int $parte
 * @property int $division
 * @property int $docente
 * @property int $hora
 * @property int $llego
 * @property int $retiro
 * @property int $falta
 *
 * @property Parte $parte0
 * @property Falta $falta0
 * @property Docente $docente0
 * @property Division $division0
 */
class Detalleparte extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalleparte';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parte', 'division', 'docente', 'hora', 'falta'], 'required'],
            [['parte', 'division', 'docente', 'hora', 'llego', 'retiro', 'falta'], 'integer'],
            [['parte'], 'exist', 'skipOnError' => true, 'targetClass' => Parte::className(), 'targetAttribute' => ['parte' => 'id']],
            [['falta'], 'exist', 'skipOnError' => true, 'targetClass' => Falta::className(), 'targetAttribute' => ['falta' => 'id']],
            [['docente'], 'exist', 'skipOnError' => true, 'targetClass' => Docente::className(), 'targetAttribute' => ['docente' => 'id']],
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
            'parte' => 'Parte',
            'division' => 'Division',
            'docente' => 'Docente',
            'hora' => 'Hora',
            'llego' => 'Llego',
            'retiro' => 'Retiro',
            'falta' => 'Tipo de Falta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParte0()
    {
        return $this->hasOne(Parte::className(), ['id' => 'parte']);
    }

       /**
    * @return \yii\db\ActiveQuery
    */
   
   public function getFalta0()
   {
       return $this->hasOne(Falta::className(), ['id' => 'falta']);
   }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocente0()
    {
        return $this->hasOne(Docente::className(), ['id' => 'docente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivision0()
    {
        return $this->hasOne(Division::className(), ['id' => 'division']);
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getHora0()
    {
        return $this->hasOne(Hora::className(), ['id' => 'hora']);
    }
}
