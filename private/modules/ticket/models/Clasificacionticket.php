<?php

namespace app\modules\ticket\models;

use Yii;

/**
 * This is the model class for table "clasificacionticket".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Ticket[] $tickets
 */
class Clasificacionticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clasificacionticket';
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
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['clasificacionticket' => 'id']);
    }
}
