<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tiponovedad".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Novedadesparte[] $novedadespartes
 */
class Tiponovedad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tiponovedad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 40],
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
    public function getNovedadespartes()
    {
        return $this->hasMany(Novedadesparte::className(), ['tiponovedad' => 'id']);
    }
}
