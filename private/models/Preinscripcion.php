<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preinscripcion".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $activo
 * @property string $inicio
 * @property string $fin
 */
class Preinscripcion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'preinscripcion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'activo'], 'required'],
            [['activo'], 'integer'],
            [['inicio', 'fin'], 'safe'],
            [['descripcion'], 'string', 'max' => 50],
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
            'activo' => 'Activo',
            'inicio' => 'Inicio',
            'fin' => 'Fin',
        ];
    }
}
