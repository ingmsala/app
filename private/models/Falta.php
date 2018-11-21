<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "falta".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Detalleparte[] $detallepartes
 */
class Falta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'falta';
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
    public function getDetallepartes()
    {
        return $this->hasMany(Detalleparte::className(), ['falta' => 'id']);
    }
}
