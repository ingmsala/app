<?php

namespace app\modules\ticket\models;

use Yii;

/**
 * This is the model class for table "prioridadticket".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Ticket[] $tickets
 */
class Prioridadticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prioridadticket';
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
        return $this->hasMany(Ticket::className(), ['prioridadticket' => 'id']);
    }
}
