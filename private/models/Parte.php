<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parte".
 *
 * @property int $id
 * @property string $fecha
 * @property int $preceptoria
 *
 * @property Detalleparte[] $detallepartes
 * @property Preceptoria $preceptoria0
 */
class Parte extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parte';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'preceptoria'], 'required'],
            [['fecha'], 'safe'],
            [['preceptoria'], 'integer'],
            [['fecha', 'preceptoria'], 'unique', 'targetAttribute' => ['fecha', 'preceptoria']],
            [['preceptoria'], 'exist', 'skipOnError' => true, 'targetClass' => Preceptoria::className(), 'targetAttribute' => ['preceptoria' => 'id']],
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
            'preceptoria' => 'Preceptoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallepartes()
    {
        return $this->hasMany(Detalleparte::className(), ['parte' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreceptoria0()
    {
        return $this->hasOne(Preceptoria::className(), ['id' => 'preceptoria']);
    }
}
