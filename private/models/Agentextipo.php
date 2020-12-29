<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "agentextipo".
 *
 * @property int $id
 * @property int $agente
 * @property int $tipocargo
 *
 * @property Agente $agente0
 * @property Tipocargo $tipocargo0
 */
class Agentextipo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agentextipo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agente', 'tipocargo'], 'required'],
            [['agente', 'tipocargo'], 'integer'],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['tipocargo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipocargo::className(), 'targetAttribute' => ['tipocargo' => 'id']],
            [['agente', 'tipocargo'], 'unique', 'targetAttribute' => ['agente', 'tipocargo']],
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
            'tipocargo' => 'Tipo de cargo',
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
    public function getTipocargo0()
    {
        return $this->hasOne(Tipocargo::className(), ['id' => 'tipocargo']);
    }
}
