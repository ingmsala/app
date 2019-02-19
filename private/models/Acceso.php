<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acceso".
 *
 * @property int $id
 * @property int $visitante
 * @property string $fechaingreso
 * @property string $fechaegreso
 * @property int $tarjeta
 * @property int $area
 *
 * @property Area $area0
 * @property Visitante $visitante0
 * @property Tarjeta $tarjeta0
 */
class Acceso extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acceso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visitante'], 'required'],
            [['visitante', 'tarjeta', 'area'], 'integer'],
            [['fechaingreso', 'fechaegreso'], 'safe'],
            [['area'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['area' => 'id']],
            [['visitante'], 'exist', 'skipOnError' => true, 'targetClass' => Visitante::className(), 'targetAttribute' => ['visitante' => 'id']],
            [['tarjeta'], 'exist', 'skipOnError' => true, 'targetClass' => Tarjeta::className(), 'targetAttribute' => ['tarjeta' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visitante' => 'Visitante',
            'fechaingreso' => 'Fecha de ingreso',
            'fechaegreso' => 'Fecha de egreso',
            'tarjeta' => 'Credencial',
            'area' => 'Area',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea0()
    {
        return $this->hasOne(Area::className(), ['id' => 'area']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitante0()
    {
        return $this->hasOne(Visitante::className(), ['id' => 'visitante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarjeta0()
    {
        return $this->hasOne(Tarjeta::className(), ['id' => 'tarjeta']);
    }
}
