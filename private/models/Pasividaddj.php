<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pasividaddj".
 *
 * @property int $id
 * @property string $regimen
 * @property string $causa
 * @property string $caja
 * @property string $fecha
 * @property double $importe
 * @property int $percibe
 * @property int $declaracionjurada
 *
 * @property Declaracionjurada $declaracionjurada0
 */
class Pasividaddj extends \yii\db\ActiveRecord
{

    const SCENARIO_DECLARACIONJURADA = 'declaracionjurada';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pasividaddj';
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DECLARACIONJURADA] = ['regimen', 'causa', 'caja', 'fecha', 'importe', 'percibe', 'declaracionjurada'];
        
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['regimen', 'causa', 'caja', 'fecha', 'importe', 'percibe', 'declaracionjurada'], 'required'],
            [['fecha'], 'safe'],
            [['importe'], 'number'],
            [['percibe', 'declaracionjurada'], 'integer'],
            [['regimen', 'causa', 'caja'], 'string', 'max' => 150],
            [['declaracionjurada'], 'exist', 'skipOnError' => true, 'targetClass' => Declaracionjurada::className(), 'targetAttribute' => ['declaracionjurada' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'regimen' => 'Régimen',
            'causa' => 'Causa',
            'caja' => 'Institución o caja que lo abona',
            'fecha' => 'Desde que fecha',
            'importe' => 'Importe',
            'percibe' => 'Percibe',
            'declaracionjurada' => 'Declaracionjurada',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeclaracionjurada0()
    {
        return $this->hasOne(Declaracionjurada::className(), ['id' => 'declaracionjurada']);
    }
}
