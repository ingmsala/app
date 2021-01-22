<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "tipoactuacion".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Actuacionedh[] $actuacionedhs
 */
class Tipoactuacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipoactuacion';
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActuacionedhs()
    {
        return $this->hasMany(Actuacionedh::className(), ['tipoactuacion' => 'id']);
    }
}
