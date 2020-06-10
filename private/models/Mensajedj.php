<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mensajedj".
 *
 * @property int $id
 * @property string $detalle
 * @property int $declaracionjurada
 * @property date $fecha
 *
 * @property Declaracionjurada $declaracionjurada0
 */
class Mensajedj extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensajedj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detalle', 'declaracionjurada'], 'required'],
            [['detalle'], 'string'],
            [['fecha'], 'safe'],
            [['declaracionjurada'], 'integer'],
            [['declaracionjurada'], 'exist', 'skipOnError' => true, 'targetClass' => Declaracionjurada::className(), 'targetAttribute' => ['declaracionjurada' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'detalle' => 'Motivo',
            'declaracionjurada' => 'Declaracionjurada',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeclaracionjurada0()
    {
        return $this->hasOne(Declaracionjurada::className(), ['id' => 'declaracionjurada']);
    }
}
