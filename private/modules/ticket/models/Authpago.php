<?php

namespace app\modules\ticket\models;

use app\models\Agente;
use Yii;

/**
 * This is the model class for table "authpago".
 *
 * @property int $id
 * @property int $ticket
 * @property int $proveedor
 * @property int $estado
 * @property string $fecha
 * @property string $ordenpago
 * @property double $monto
 *
 * @property Estadoauthpago $estado0
 * @property Proveedorpago $proveedor0
 * @property Ticket $ticket0
 */
class Authpago extends \yii\db\ActiveRecord
{
    public $proveedorsearch;
    public $ordenpagosearch;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'authpago';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ticket', 'proveedor', 'estado', 'ordenpago', 'agente', 'activo'], 'required'],
            [['ticket', 'proveedor', 'estado', 'agente', 'activo'], 'integer'],
            [['fecha'], 'safe'],
            [['monto'], 'number'],
            [['ordenpago'], 'string', 'max' => 150],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoauthpago::className(), 'targetAttribute' => ['estado' => 'id']],
            [['proveedor'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedorpago::className(), 'targetAttribute' => ['proveedor' => 'id']],
            [['ticket'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket' => 'id']],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ticket' => 'Ticket',
            'proveedor' => 'Proveedor',
            'estado' => 'Estado de Orden',
            'fecha' => 'Fecha',
            'ordenpago' => 'N° Orden de pago',
            'monto' => 'Monto',
            'proveedorsearch' => 'Proveedor (Nombre o CUIT)',
            'ordenpagosearch' => 'N° Orden de pago',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estadoauthpago::className(), ['id' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedor0()
    {
        return $this->hasOne(Proveedorpago::className(), ['id' => 'proveedor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket0()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'ticket']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgente0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'agente']);
    }
}
