<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "turno".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Division[] $divisions
 * @property Preceptoria[] $preceptorias
 */
class Turno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'turno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 15],
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
    public function getDivisions()
    {
        return $this->hasMany(Division::className(), ['turno' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreceptorias()
    {
        return $this->hasMany(Preceptoria::className(), ['turno' => 'id']);
    }
}
