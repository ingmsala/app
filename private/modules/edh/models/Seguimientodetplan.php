<?php

namespace app\modules\edh\models;

use app\models\Agente;
use Yii;

/**
 * This is the model class for table "seguimientodetplan".
 *
 * @property int $id
 * @property string $fecha
 * @property string $descripcion
 * @property string $plazo
 * @property int $detalleplan
 * @property int $creado
 *
 * @property Agente $creado0
 * @property Detalleplancursado $detalleplan0
 */
class Seguimientodetplan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguimientodetplan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'descripcion', 'detalleplan', 'creado'], 'required'],
            [['fecha', 'plazo'], 'safe'],
            [['descripcion'], 'string'],
            [['detalleplan', 'creado'], 'integer'],
            [['creado'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['creado' => 'id']],
            [['detalleplan'], 'exist', 'skipOnError' => true, 'targetClass' => Detalleplancursado::className(), 'targetAttribute' => ['detalleplan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'descripcion' => 'Descripcion',
            'plazo' => 'Plazo',
            'detalleplan' => 'Detalleplan',
            'creado' => 'Creado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreado0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'creado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleplan0()
    {
        return $this->hasOne(Detalleplancursado::className(), ['id' => 'detalleplan']);
    }
}
