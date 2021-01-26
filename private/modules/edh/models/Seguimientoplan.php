<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "seguimientoplan".
 *
 * @property int $id
 * @property string $fecha
 * @property string $descripcion
 * @property int $plan
 *
 * @property Plancursado $plan0
 */
class Seguimientoplan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguimientoplan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'descripcion', 'plan'], 'required'],
            [['fecha'], 'safe'],
            [['descripcion'], 'string'],
            [['plan'], 'integer'],
            [['plan'], 'exist', 'skipOnError' => true, 'targetClass' => Plancursado::className(), 'targetAttribute' => ['plan' => 'id']],
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
            'plan' => 'Plan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan0()
    {
        return $this->hasOne(Plancursado::className(), ['id' => 'plan']);
    }
}
