<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipocargo".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Agentextipo[] $agentextipos
 */
class Tipocargo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipocargo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgentextipos()
    {
        return $this->hasMany(Agentextipo::className(), ['tipocargo' => 'id']);
    }
}
