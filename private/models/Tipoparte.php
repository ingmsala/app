<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipoparte".
 *
 * @property int $id
 * @property string $nombre
 */
class Tipoparte extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipoparte';
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
            'nombre' => 'Nombre',
        ];
    }

    public function getPartes()
    {
        return $this->hasMany(parte::className(), ['tipoparte' => 'id']);
    }
}
