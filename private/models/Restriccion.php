<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "restriccion".
 *
 * @property int $id
 * @property string $motivo
 * @property int $visitante
 *
 * @property Visitante $visitante0
 */
class Restriccion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restriccion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['motivo', 'visitante'], 'required'],
            [['visitante'], 'integer'],
            [['motivo'], 'string', 'max' => 50],
            [['visitante'], 'exist', 'skipOnError' => true, 'targetClass' => Visitante::className(), 'targetAttribute' => ['visitante' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'motivo' => 'Motivo',
            'visitante' => 'Visitante',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitante0()
    {
        return $this->hasOne(Visitante::className(), ['id' => 'visitante']);
    }
}
