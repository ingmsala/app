<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parametros".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $estado
 */
class Parametros extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parametros';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'estado'], 'required'],
            [['estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'estado' => 'Estado',
        ];
    }
}
