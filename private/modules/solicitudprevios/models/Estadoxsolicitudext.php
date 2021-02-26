<?php

namespace app\modules\solicitudprevios\models;

use app\models\Agente;
use Yii;

/**
 * This is the model class for table "estadoxsolicitudext".
 *
 * @property int $id
 * @property int $estado
 * @property int $detalle
 * @property string $motivo
 * @property string $fecha
 *
 * @property Detallesolicitudext $detalle0
 * @property Estadodetallesolicitudext $estado0
 */
class Estadoxsolicitudext extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadoxsolicitudext';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado', 'detalle', 'fecha'], 'required'],
            [['estado', 'detalle', 'agente'], 'integer'],
            [['motivo'], 'string'],
            [['fecha'], 'safe'],
            [['detalle'], 'exist', 'skipOnError' => true, 'targetClass' => Detallesolicitudext::className(), 'targetAttribute' => ['detalle' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadodetallesolicitudext::className(), 'targetAttribute' => ['estado' => 'id']],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'estado' => 'Estado',
            'detalle' => 'Detalle',
            'motivo' => 'Motivo',
            'fecha' => 'Fecha',
            'agente' => 'Agente',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalle0()
    {
        return $this->hasOne(Detallesolicitudext::className(), ['id' => 'detalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estadodetallesolicitudext::className(), ['id' => 'estado']);
    }
    public function getAgente0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'agente']);
    }
}
