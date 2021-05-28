<?php

namespace app\modules\becas\models;


use Yii;
use app\models\Agente;

/**
 * This is the model class for table "becaestadoxsolicitud".
 *
 * @property int $id
 * @property int $solicitud
 * @property int $estado
 * @property string $fecha
 * @property int $agente
 * @property string $comentario
 *
 * @property Agente $agente0
 * @property Becaestadosolicitud $estado0
 * @property Becasolicitud $solicitud0
 */
class Becaestadoxsolicitud extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becaestadoxsolicitud';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['solicitud', 'estado', 'fecha'], 'required'],
            [['solicitud', 'estado', 'agente'], 'integer'],
            [['fecha'], 'safe'],
            [['comentario'], 'string'],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Becaestadosolicitud::className(), 'targetAttribute' => ['estado' => 'id']],
            [['solicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Becasolicitud::className(), 'targetAttribute' => ['solicitud' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'solicitud' => 'Solicitud',
            'estado' => 'Estado',
            'fecha' => 'Fecha',
            'agente' => 'Agente',
            'comentario' => 'Comentario',
        ];
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
    public function getEstado0()
    {
        return $this->hasOne(Becaestadosolicitud::className(), ['id' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitud0()
    {
        return $this->hasOne(Becasolicitud::className(), ['id' => 'solicitud']);
    }
}
