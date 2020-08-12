<?php

namespace app\modules\libroclase\models;

use Yii;

/**
 * This is the model class for table "unidad".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Detalleunidad[] $detalleunidads
 */
class Unidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Unidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleunidads()
    {
        return $this->hasMany(Detalleunidad::className(), ['unidad' => 'id']);
    }
}
