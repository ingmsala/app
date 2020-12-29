<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tribunal".
 *
 * @property int $id
 * @property int $docente
 * @property int $mesaexamen
 *
 * @property Agente $agente0
 * @property Mesaexamen $mesaexamen0
 */
class Tribunal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tribunal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agente', 'mesaexamen'], 'required'],
            [['agente', 'mesaexamen'], 'integer'],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['mesaexamen'], 'exist', 'skipOnError' => true, 'targetClass' => Mesaexamen::className(), 'targetAttribute' => ['mesaexamen' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agente' => 'Agente',
            'mesaexamen' => 'Mesaexamen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgente0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'agente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMesaexamen0()
    {
        return $this->hasOne(Mesaexamen::className(), ['id' => 'mesaexamen']);
    }
}
