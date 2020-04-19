<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clasevirtual".
 *
 * @property int $id
 * @property int $catedra
 * @property int $hora
 * @property int $semana
 * @property string $fecha
 *
 * @property Catedra $catedra0
 * @property Hora $hora0
 * @property Semana $semana0
 */
class Clasevirtual extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clasevirtual';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catedra', 'hora', 'semana', 'fecha'], 'required'],
            [['catedra', 'hora', 'semana'], 'integer'],
            [['fecha'], 'safe'],
            [['catedra'], 'exist', 'skipOnError' => true, 'targetClass' => Catedra::className(), 'targetAttribute' => ['catedra' => 'id']],
            [['hora'], 'exist', 'skipOnError' => true, 'targetClass' => Hora::className(), 'targetAttribute' => ['hora' => 'id']],
            [['semana'], 'exist', 'skipOnError' => true, 'targetClass' => Semana::className(), 'targetAttribute' => ['semana' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catedra' => 'Catedra',
            'hora' => 'Hora',
            'semana' => 'Semana',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatedra0()
    {
        return $this->hasOne(Catedra::className(), ['id' => 'catedra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHora0()
    {
        return $this->hasOne(Hora::className(), ['id' => 'hora']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemana0()
    {
        return $this->hasOne(Semana::className(), ['id' => 'semana']);
    }
}
