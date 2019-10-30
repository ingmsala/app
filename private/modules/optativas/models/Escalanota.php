<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "escalanota".
 *
 * @property int $id
 * @property string $nombre
 * @property int $estado
 *
 * @property Acta[] $actas
 * @property Detalleescalanota[] $detalleescalanotas
 */
class Escalanota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'escalanota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'estado'], 'required'],
            [['estado'], 'integer'],
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
            'nombre' => 'Nombre',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActas()
    {
        return $this->hasMany(Acta::className(), ['escalanota' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleescalanotas()
    {
        return $this->hasMany(Detalleescalanota::className(), ['escalanota' => 'id']);
    }
}
