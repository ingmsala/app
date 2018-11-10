<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hora".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Detalleparte[] $detallepartes
 */
class Hora extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hora';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 15],
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
    public function getDetallepartes()
    {
        return $this->hasMany(Detalleparte::className(), ['hora' => 'id']);
    }
}
