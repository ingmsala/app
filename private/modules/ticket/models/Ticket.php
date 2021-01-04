<?php

namespace app\modules\ticket\models;

use app\models\Agente;
use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property string $fecha
 * @property string $hora
 * @property string $asunto
 * @property string $descripcion
 * @property int $estadoticket
 * @property int $agente
 * @property int $asignacionticket
 * @property int $prioridadticket
 * @property int $clasificacionticket
 *
 * @property Adjuntoticket[] $adjuntotickets
 * @property Detalleticket[] $detalletickets
 * @property Agente $agente0
 * @property Asignacionticket $asignacionticket0
 * @property Clasificacionticket $clasificacionticket0
 * @property Estadoticket $estadoticket0
 * @property Prioridadticket $prioridadticket0
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'hora', 'asunto', 'descripcion', 'estadoticket', 'agente', 'asignacionticket', 'prioridadticket'], 'required'],
            [['fecha', 'hora'], 'safe'],
            [['descripcion'], 'string'],
            [['estadoticket', 'agente', 'asignacionticket', 'prioridadticket', 'clasificacionticket'], 'integer'],
            [['asunto'], 'string', 'max' => 300],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['asignacionticket'], 'exist', 'skipOnError' => true, 'targetClass' => Asignacionticket::className(), 'targetAttribute' => ['asignacionticket' => 'id']],
            [['clasificacionticket'], 'exist', 'skipOnError' => true, 'targetClass' => Clasificacionticket::className(), 'targetAttribute' => ['clasificacionticket' => 'id']],
            [['estadoticket'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoticket::className(), 'targetAttribute' => ['estadoticket' => 'id']],
            [['prioridadticket'], 'exist', 'skipOnError' => true, 'targetClass' => Prioridadticket::className(), 'targetAttribute' => ['prioridadticket' => 'id']],
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
            'asunto' => 'Asunto',
            'descripcion' => 'Descripción',
            'estadoticket' => 'Estado',
            'agente' => 'Creado por',
            'asignacionticket' => 'Asignado a',
            'prioridadticket' => 'Prioridad',
            'clasificacionticket' => 'Clasificación',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdjuntotickets()
    {
        return $this->hasMany(Adjuntoticket::className(), ['ticket' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalletickets()
    {
        return $this->hasMany(Detalleticket::className(), ['ticket' => 'id']);
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
    public function getClasificacionticket0()
    {
        return $this->hasOne(Clasificacionticket::className(), ['id' => 'clasificacionticket']);
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
    public function getPrioridadticket0()
    {
        return $this->hasOne(Prioridadticket::className(), ['id' => 'prioridadticket']);
    }
}
