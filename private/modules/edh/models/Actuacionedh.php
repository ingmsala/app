<?php

namespace app\modules\edh\models;

use app\models\Agente;
use Yii;

/**
 * This is the model class for table "actuacionedh".
 *
 * @property int $id
 * @property int $area
 * @property string $fecha
 * @property int $lugaractuacion
 * @property string $registro
 * @property string $fechacreate
 * @property int $agente
 * @property int $tipoactuacion
 *
 * @property Actorxactuacion[] $actorxactuacions
 * @property Agente $agente0
 * @property Areasolicitud $area0
 * @property Lugaractuacion $lugaractuacion0
 * @property Tipoactuacion $tipoactuacion0
 * @property Areainformaact[] $areainformaacts
 */
class Actuacionedh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actuacionedh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['area', 'lugaractuacion', 'agente', 'tipoactuacion', 'caso'], 'integer'],
            [['fecha', 'fechacreate'], 'safe'],
            [['registro'], 'string'],
            [['fechacreate', 'agente', 'tipoactuacion'], 'required'],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['area'], 'exist', 'skipOnError' => true, 'targetClass' => Areasolicitud::className(), 'targetAttribute' => ['area' => 'id']],
            [['lugaractuacion'], 'exist', 'skipOnError' => true, 'targetClass' => Lugaractuacion::className(), 'targetAttribute' => ['lugaractuacion' => 'id']],
            [['tipoactuacion'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoactuacion::className(), 'targetAttribute' => ['tipoactuacion' => 'id']],
            [['caso'], 'exist', 'skipOnError' => true, 'targetClass' => Caso::className(), 'targetAttribute' => ['caso' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area' => 'Área',
            'fecha' => 'Fecha',
            'lugaractuacion' => 'Lugar de actuación',
            'registro' => 'Registro',
            'fechacreate' => 'Fechacreate',
            'agente' => 'Agente',
            'tipoactuacion' => 'Tipoactuacion',
            'caso' => 'Caso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActorxactuacions()
    {
        return $this->hasMany(Actorxactuacion::className(), ['actuacion' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgente0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'agente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea0()
    {
        return $this->hasOne(Areasolicitud::className(), ['id' => 'area']);
    }

    public function getCaso0()
    {
        return $this->hasOne(Caso::className(), ['id' => 'caso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLugaractuacion0()
    {
        return $this->hasOne(Lugaractuacion::className(), ['id' => 'lugaractuacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoactuacion0()
    {
        return $this->hasOne(Tipoactuacion::className(), ['id' => 'tipoactuacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreainformaacts()
    {
        return $this->hasMany(Areainformaact::className(), ['actuacion' => 'id']);
    }
}
