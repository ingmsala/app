<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadotarea".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Tareamantenimiento[] $tareamantenimientos
 */
class Estadotarea extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadotarea';
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
        return $this->hasMany(Tareamantenimiento::className(), ['estadotarea' => 'id']);
    }
}
