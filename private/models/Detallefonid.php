<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detallefonid".
 *
 * @property int $id
 * @property string $jurisdiccion
 * @property string $denominacion
 * @property string $nombre
 * @property string $cargo
 * @property double $horas
 * @property int $tipo
 * @property string $observaciones
 * @property int $fonid
 */
class Detallefonid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detallefonid';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jurisdiccion', 'denominacion', 'nombre', 'cargo', 'horas', 'tipo', 'fonid'], 'required'],
            [['horas'], 'number'],
            [['tipo', 'fonid'], 'integer'],
            [['jurisdiccion', 'cargo'], 'string', 'max' => 200],
            [['denominacion', 'nombre', 'observaciones'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jurisdiccion' => 'Jurisdiccion',
            'denominacion' => 'Denominacion',
            'nombre' => 'Nombre',
            'cargo' => 'Cargo',
            'horas' => 'Horas',
            'tipo' => 'Tipo',
            'observaciones' => 'Observaciones',
            'fonid' => 'Fonid',
        ];
    }
}
