<?php

namespace app\modules\ticket\models;

use Yii;

/**
 * This is the model class for table "adjuntoticket".
 *
 * @property int $id
 * @property string $url
 * @property int $ticket
 * @property int $detalleticket
 *
 * @property Detalleticket $detalleticket0
 * @property Ticket $ticket0
 */
class Adjuntoticket extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adjuntoticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'nombre'], 'required'],
            [['ticket', 'detalleticket'], 'integer'],
            [['image'], 'safe'],
            [['url', 'nombre'], 'string', 'max' => 300],
            [['url'], 'unique'],
            [['detalleticket'], 'exist', 'skipOnError' => true, 'targetClass' => Detalleticket::className(), 'targetAttribute' => ['detalleticket' => 'id']],
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
            'url' => 'Url',
            'ticket' => 'Ticket',
            'detalleticket' => 'Detalleticket',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleticket0()
    {
        return $this->hasOne(Detalleticket::className(), ['id' => 'detalleticket']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */ 
    public function getTicket0()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'ticket']);
    }
}
