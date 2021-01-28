<?php

namespace app\models;

use app\modules\horarioespecial\models\Habilitacionce;
use Yii;

/**
 * This is the model class for table "division".
 *
 * @property int $id
 * @property string $nombre
 * @property int $turno
 * @property int $propuesta
 * @property int $preceptoria
 *
 * @property Catedra[] $catedras
 * @property Detalleparte[] $detallepartes
 * @property Preceptoria $preceptoria0
 * @property Turno $turno0
 * @property Propuesta $propuesta0
 * @property Nombramiento[] $nombramientos
 */
class Division extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'division';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'propuesta'], 'required'],
            [['turno', 'propuesta', 'preceptoria'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['enlaceclase'], 'string'],
            [['preceptoria'], 'exist', 'skipOnError' => true, 'targetClass' => Preceptoria::className(), 'targetAttribute' => ['preceptoria' => 'id']],
            [['turno'], 'exist', 'skipOnError' => true, 'targetClass' => Turno::className(), 'targetAttribute' => ['turno' => 'id']],
            [['propuesta'], 'exist', 'skipOnError' => true, 'targetClass' => Propuesta::className(), 'targetAttribute' => ['propuesta' => 'id']],
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
            'turno' => 'Turno',
            'propuesta' => 'Propuesta',
            'preceptoria' => 'Preceptoria',
            'enlaceclase' => 'Enlace de clase',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatedras()
    {
        return $this->hasMany(Catedra::className(), ['division' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallepartes()
    {
        return $this->hasMany(Detalleparte::className(), ['division' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreceptoria0()
    {
        return $this->hasOne(Preceptoria::className(), ['id' => 'preceptoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurno0()
    {
        return $this->hasOne(Turno::className(), ['id' => 'turno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropuesta0()
    {
        return $this->hasOne(Propuesta::className(), ['id' => 'propuesta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNombramientos()
    {
        return $this->hasMany(Nombramiento::className(), ['division' => 'id']);
    }

    public function getHabilitacionces() 
   { 
       return $this->hasMany(Habilitacionce::className(), ['division' => 'id']); 
   } 
    public function getPreceptor0() 
   { 
    return $this->hasOne(Nombramiento::className(), ['division' => 'id']); 
   } 
    public function getJefe0() 
   {
       $rxu = Rolexuser::find()->where(['subrole' => $this->preceptoria0->nombre])->one();
       return Agente::find()->where(['mail' => $rxu->user0->username])->one();
        return $this->hasOne(Nombramiento::className(), ['division' => 'id']); 
   } 
}
