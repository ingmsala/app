<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "declaracionjurada".
 *
 * @property int $id
 * @property int $persona
 * @property int $estadodeclaracion
 * @property string $fecha
 * @property int $actividadnooficial
 * @property int $pasividad
 *
 * @property Actividadnooficial[] $actividadnooficials
 * @property Docente $persona0
 * @property Nodocente $persona1
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
            //[['persona', 'estadodeclaracion', 'fecha', 'actividadnooficial', 'pasividad'], 'required'],
            [['fecha'], 'required'],
            [['persona', 'estadodeclaracion', 'actividadnooficial', 'pasividad'], 'integer'],
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
            'persona' => 'Persona',
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
    public function getDocente0()
    {
        return $this->hasOne(Docente::className(), ['documento' => 'persona']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNodocente0()
    {
        return $this->hasOne(Nodocente::className(), ['documento' => 'persona']);
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
