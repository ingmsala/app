<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prioridadtarea".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Tareamantenimiento[] $tareamantenimientos
 */
class Prioridadtarea extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prioridadtarea';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 35],
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
    public function getTareamantenimientos()
    {
        return $this->hasMany(Tareamantenimiento::className(), ['prioridadtarea' => 'id']);
    }
}
