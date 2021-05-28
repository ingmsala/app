<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parentesco".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Becaconviviente[] $becaconvivientes
 * @property Becasolicitante[] $becasolicitantes
 */
class Parentesco extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parentesco';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 70],
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
    public function getBecaconvivientes()
    {
        return $this->hasMany(Becaconviviente::className(), ['parentesco' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecasolicitantes()
    {
        return $this->hasMany(Becasolicitante::className(), ['parentesco' => 'id']);
    }
}
