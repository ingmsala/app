<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadonovedad".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Novedadesparte[] $novedadespartes
 */
class Estadonovedad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadonovedad';
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
        return $this->hasMany(Novedadesparte::className(), ['estadonovedad' => 'id']);
    }
}
