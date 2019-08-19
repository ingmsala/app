<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parte".
 *
 * @property int $id
 * @property string $fecha
 * @property int $preceptoria
 * @property int $tipoparte
 *
 * @property Detalleparte[] $detallepartes
 * @property Preceptoria $preceptoria0
 */
class Parte extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const SCENARIO_ABM = 'create';
    const SCENARIO_SEARCHINDEX = 'index';

    public $mes;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ABM] = ['id', 'fecha', 'preceptoria', 'tipoparte'];
        $scenarios[self::SCENARIO_SEARCHINDEX] = ['fecha', 'mes'];
        return $scenarios;
    }

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
            [['fecha', 'preceptoria', 'tipoparte'], 'required'],
            [['fecha'], 'safe'],
            [['preceptoria', 'tipoparte'], 'integer'],
            [['fecha', 'preceptoria'], 'unique', 'targetAttribute' => ['fecha', 'preceptoria']],
            [['preceptoria'], 'exist', 'skipOnError' => true, 'targetClass' => Preceptoria::className(), 'targetAttribute' => ['preceptoria' => 'id']],
            [['tipoparte'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoparte::className(), 'targetAttribute' => ['tipoparte' => 'id']],
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
            'tipoparte' => 'Tipo de Parte',
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

    public function getTipoparte0()
    {
        return $this->hasOne(Tipoparte::className(), ['id' => 'tipoparte']);
    }

       /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedadespartes()
    {
        return $this->hasMany(Novedadesparte::className(), ['parte' => 'id']);
    }
}
