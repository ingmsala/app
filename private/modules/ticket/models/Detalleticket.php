<?php

namespace app\modules\ticket\models;

use app\models\Agente;
use Yii;

/**
 * This is the model class for table "detalleticket".
 *
 * @property int $id
 * @property string $fecha
 * @property string $hora
 * @property string $descripcion
 * @property int $ticket
 * @property int $agente
 * @property int $estadoticket
 * @property int $asignacionticket
 *
 * @property Adjuntoticket[] $adjuntotickets
 * @property Agente $agente0
 * @property Asignacionticket $asignacionticket0
 * @property Estadoticket $estadoticket0
 * @property Ticket $ticket0
 */
class Detalleticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalleticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'hora', 'descripcion', 'ticket', 'agente', 'estadoticket', 'asignacionticket'], 'required'],
            [['fecha', 'hora'], 'safe'],
            [['descripcion'], 'string'],
            [['ticket', 'agente', 'estadoticket', 'asignacionticket'], 'integer'],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['asignacionticket'], 'exist', 'skipOnError' => true, 'targetClass' => Asignacionticket::className(), 'targetAttribute' => ['asignacionticket' => 'id']],
            [['estadoticket'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoticket::className(), 'targetAttribute' => ['estadoticket' => 'id']],
            [['ticket'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'descripcion' => 'Descripcion',
            'ticket' => 'Ticket',
            'agente' => 'Agente',
            'estadoticket' => 'Estado',
            'asignacionticket' => 'Asignacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdjuntotickets()
    {
        return $this->hasMany(Adjuntoticket::className(), ['detalleticket' => 'id']);
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
    public function getAsignacionticket0()
    {
        return $this->hasOne(Asignacionticket::className(), ['id' => 'asignacionticket']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoticket0()
    {
        return $this->hasOne(Estadoticket::className(), ['id' => 'estadoticket']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket0()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'ticket']);
    }
}