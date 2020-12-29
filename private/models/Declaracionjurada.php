<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "declaracionjurada".
 *
 * @property int $id
 * @property int $agente
 * @property int $estadodeclaracion
 * @property string $fecha
 * @property int $actividadnooficial
 * @property int $pasividad
 *
 * @property Actividadnooficial[] $actividadnooficials
 * @property Agente $agente0
 * @property Estadodj $estadodeclaracion0
 * @property Funciondj[] $funciondjs
 * @property Pasividaddj[] $pasividaddjs
 */
class Declaracionjurada extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'declaracionjurada';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['agente', 'estadodeclaracion', 'fecha', 'actividadnooficial', 'pasividad'], 'required'],
            [['fecha'], 'required'],
            [['agente', 'estadodeclaracion', 'actividadnooficial', 'pasividad'], 'integer'],
            [['fecha'], 'safe'],
            [['estadodeclaracion'], 'exist', 'skipOnError' => true, 'targetClass' => Estadodj::className(), 'targetAttribute' => ['estadodeclaracion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agente' => 'Agente',
            'estadodeclaracion' => 'Estadodeclaracion',
            'fecha' => 'Fecha',
            'actividadnooficial' => 'Actividadnooficial',
            'pasividad' => 'Pasividad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividadnooficials()
    {
        return $this->hasMany(Actividadnooficial::className(), ['declaracionjurada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgente0()
    {
        return $this->hasOne(Agente::className(), ['documento' => 'agente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadodeclaracion0()
    {
        return $this->hasOne(Estadodj::className(), ['id' => 'estadodeclaracion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunciondjs()
    {
        return $this->hasMany(Funciondj::className(), ['declaracionjurada' => 'id']);
    }

    public function getMensajedjs() 
   { 
       return $this->hasMany(Mensajedj::className(), ['declaracionjurada' => 'id']); 
   }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPasividaddjs()
    {
        return $this->hasMany(Pasividaddj::className(), ['declaracionjurada' => 'id']);
    }
}
