<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "condicionnota".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Detalleescalanota[] $detalleescalanotas
 */
class Condicionnota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'condicionnota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 10],
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
    public function getDetalleescalanotas()
    {
        return $this->hasMany(Detalleescalanota::className(), ['condicionnota' => 'id']);
    }
}
