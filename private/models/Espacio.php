<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "espacio".
 *
 * @property int $id
 * @property string $nombre
 * @property string $piso
 *
 * @property Detallemodulo[] $detallemodulos
 */
class Espacio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'espacio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nombre', 'piso'], 'required'],
            [['id'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['piso'], 'string', 'max' => 50],
            [['id'], 'unique'],
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
            'piso' => 'Piso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallemodulos()
    {
        return $this->hasMany(Detallemodulo::className(), ['espacio' => 'id']);
    }
}
