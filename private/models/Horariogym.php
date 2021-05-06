<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "horariogym".
 *
 * @property int $id
 * @property int $division
 * @property int $diasemana
 * @property string $horario
 * @property string $docentes
 * @property int $repite
 * @property int $burbuja
 *
 * @property Diasemana $diasemana0
 * @property Division $division0
 */
class Horariogym extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horariogym';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['division', 'diasemana', 'burbuja'], 'required'],
            [['division', 'diasemana', 'repite', 'burbuja'], 'integer'],
            [['horario'], 'string', 'max' => 150],
            [['docentes'], 'string', 'max' => 500],
            [['diasemana'], 'exist', 'skipOnError' => true, 'targetClass' => Diasemana::className(), 'targetAttribute' => ['diasemana' => 'id']],
            [['division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'division' => 'Division',
            'diasemana' => 'Diasemana',
            'horario' => 'Horario',
            'docentes' => 'Docentes',
            'repite' => 'Repite',
            'burbuja' => 'Burbuja',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiasemana0()
    {
        return $this->hasOne(Diasemana::className(), ['id' => 'diasemana']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivision0()
    {
        return $this->hasOne(Division::className(), ['id' => 'division']);
    }
}
