<?php

namespace app\modules\ticket\models;

use app\models\Agente;
use Yii;

/**
 * This is the model class for table "grupotrabajoticket".
 *
 * @property int $id
 * @property int $areaticket
 * @property int $agente
 *
 * @property Agente $agente0
 * @property Areaticket $areaticket0
 */
class Grupotrabajoticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupotrabajoticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['areaticket', 'agente'], 'required'],
            [['areaticket', 'agente'], 'integer'],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['areaticket'], 'exist', 'skipOnError' => true, 'targetClass' => Areaticket::className(), 'targetAttribute' => ['areaticket' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'areaticket' => 'Área',
            'agente' => 'Agente',
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
    public function getAreaticket0()
    {
        return $this->hasOne(Areaticket::className(), ['id' => 'areaticket']);
    }
}
