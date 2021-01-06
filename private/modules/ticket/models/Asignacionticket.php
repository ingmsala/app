<?php

namespace app\modules\ticket\models;

use app\models\Agente;
use Yii;

/**
 * This is the model class for table "asignacionticket".
 *
 * @property int $id
 * @property int $agente
 * @property int $areaticket
 *
 * @property Agente $agente0
 * @property Areaticket $areaticket0
 * @property Detalleticket[] $detalletickets
 * @property Ticket[] $tickets
 */
class Asignacionticket extends \yii\db\ActiveRecord
{
    const SCENARIO_AGENTE_REQ = 'agte';
    const SCENARIO_AGENTE_NOREQ = 'agteno';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_AGENTE_REQ] = ['agente', 'areaticket'];
        $scenarios[self::SCENARIO_AGENTE_NOREQ] = ['agente', 'areaticket'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asignacionticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agente', 'areaticket', 'ticket', 'detalleticket', 'anteriorasignacion'], 'integer'],
            [['agente'], 'required', 'message' => 'El ticket debe ser asignado a un área o persona', 'on'=>self::SCENARIO_AGENTE_REQ],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['areaticket'], 'exist', 'skipOnError' => true, 'targetClass' => Areaticket::className(), 'targetAttribute' => ['areaticket' => 'id']],
            [['ticket'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket' => 'id']],
            [['detalleticket'], 'exist', 'skipOnError' => true, 'targetClass' => Detalleticket::className(), 'targetAttribute' => ['detalleticket' => 'id']],
            [['anteriorasignacion'], 'exist', 'skipOnError' => true, 'targetClass' => Asignacionticket::className(), 'targetAttribute' => ['anteriorasignacion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agente' => 'Asignar a',
            'areaticket' => 'Asignar a',
            'ticket' => 'Ticket',
            'detalleticket' => 'Detalle ticket',
            'anteriorasignacion' => 'Anterior',
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
    public function getAreaticket0()
    {
        return $this->hasOne(Areaticket::className(), ['id' => 'areaticket']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleticket0()
    {
        return $this->hasMany(Detalleticket::className(), ['id' => 'detalleticket']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket0()
    {
        return $this->hasMany(Ticket::className(), ['id' => 'ticket']);
    }

    public function getAnteriorasignacion0()
    {
        return $this->hasMany(Asignacionticket::className(), ['id' => 'anteriorasignacion']);
    }
}
