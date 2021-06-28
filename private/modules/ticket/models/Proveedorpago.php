<?php

namespace app\modules\ticket\models;

use Yii;

/**
 * This is the model class for table "proveedorpago".
 *
 * @property int $id
 * @property string $nombre
 * @property string $cuit
 * @property string $mail
 * @property string $telefono
 * @property string $direccion
 * @property int $estado
 *
 * @property Authpago[] $authpagos
 */
class Proveedorpago extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proveedorpago';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'cuit', 'estado'], 'required'],
            [['estado'], 'integer'],
            [['nombre'], 'string', 'max' => 200],
            ['mail', 'email'],
            [['cuit'], 'unique', 'targetAttribute' => ['cuit']],
            [['cuit'], 'string', 'max' => 13],
            [['cuit'], 'string', 'min' => 13],
            [['mail', 'telefono', 'direccion'], 'string', 'max' => 150],
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
            'cuit' => 'CUIT',
            'mail' => 'Correo electrónico',
            'telefono' => 'Teléfono',
            'direccion' => 'Dirección',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthpagos()
    {
        return $this->hasMany(Authpago::className(), ['proveedor' => 'id']);
    }
}
