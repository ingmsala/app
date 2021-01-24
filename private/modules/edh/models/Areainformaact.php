<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "areainformaact".
 *
 * @property int $id
 * @property int $area
 * @property int $actuacion
 *
 * @property Actuacionedh $actuacion0
 * @property Areasolicitud $area0
 */
class Areainformaact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'areainformaact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actuacion'], 'required'],
            [['area', 'actuacion'], 'integer'],
            [['actuacion'], 'exist', 'skipOnError' => true, 'targetClass' => Actuacionedh::className(), 'targetAttribute' => ['actuacion' => 'id']],
            [['area'], 'exist', 'skipOnError' => true, 'targetClass' => Areasolicitud::className(), 'targetAttribute' => ['area' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area' => 'Se informa a',
            'actuacion' => 'Actuación',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActuacion0()
    {
        return $this->hasOne(Actuacionedh::className(), ['id' => 'actuacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea0()
    {
        return $this->hasOne(Areasolicitud::className(), ['id' => 'area']);
    }
}
