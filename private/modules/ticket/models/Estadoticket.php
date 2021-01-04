<?php

namespace app\modules\ticket\models;

use Yii;

/**
 * This is the model class for table "estadoticket".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Detalleticket[] $detalletickets
 * @property Ticket[] $tickets
 */
class Estadoticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadoticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalletickets()
    {
        return $this->hasMany(Detalleticket::className(), ['estadoticket' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['estadoticket' => 'id']);
    }
}
