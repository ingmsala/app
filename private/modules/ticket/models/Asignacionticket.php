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
            [['agente', 'areaticket'], 'integer'],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['areaticket'], 'exist', 'skipOnError' => true, 'targetClass' => Areaticket::className(), 'targetAttribute' => ['areaticket' => 'id']],
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
    public function getDetalletickets()
    {
        return $this->hasMany(Detalleticket::className(), ['asignacionticket' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['asignacionticket' => 'id']);
    }
}
