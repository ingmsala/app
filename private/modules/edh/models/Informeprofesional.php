<?php

namespace app\modules\edh\models;


use Yii;
use app\models\Agente;

/**
 * This is the model class for table "informeprofesional".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $fecha
 * @property int $areasolicitud
 * @property int $agente
 * @property int $solicitud
 *
 * @property Areasolicitud $areasolicitud0
 * @property Agente $agente0
 * @property Solicitudedh $solicitud0
 */
class Informeprofesional extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'informeprofesional';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'fecha', 'agente', 'solicitud'], 'required'],
            [['descripcion'], 'string'],
            [['fecha'], 'safe'],
            [['areasolicitud', 'agente', 'solicitud'], 'integer'],
            [['areasolicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Areasolicitud::className(), 'targetAttribute' => ['areasolicitud' => 'id']],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['solicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitudedh::className(), 'targetAttribute' => ['solicitud' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripción',
            'fecha' => 'Fecha',
            'areasolicitud' => 'Área',
            'agente' => 'Agente',
            'solicitud' => 'Solicitud',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreasolicitud0()
    {
        return $this->hasOne(Areasolicitud::className(), ['id' => 'areasolicitud']);
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
    public function getSolicitud0()
    {
        return $this->hasOne(Solicitudedh::className(), ['id' => 'solicitud']);
    }
}
