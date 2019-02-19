<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tarjeta".
 *
 * @property int $id
 * @property int $codigo
 * @property int $estado
 *
 * @property Acceso[] $accesos
 */
class Tarjeta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tarjeta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'estado'], 'required'],
            [['codigo', 'estado'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccesos()
    {
        return $this->hasMany(Acceso::className(), ['tarjeta' => 'id']);
    }
}
