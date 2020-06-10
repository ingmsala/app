<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadodj".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Declaracionjurada[] $declaracionjuradas
 */
class Estadodj extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadodj';
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
    public function getDeclaracionjuradas()
    {
        return $this->hasMany(Declaracionjurada::className(), ['estadodeclaracion' => 'id']);
    }
}
