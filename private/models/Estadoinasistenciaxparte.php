<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadoinasistenciaxparte".
 *
 * @property int $id
 * @property string $detalle
 * @property int $estadoinasistencia
 * @property string $fecha
 * @property int $parte
 * @property int $falta

 *
 * @property Detalleparte $parte0
 * @property Falta $falta0
 * @property Estadoinasistencia $estadoinasistencia0
 */
class Estadoinasistenciaxparte extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const SCENARIO_COMISONREG = 'detalleparteesc';

    public static function tableName()
    {
        return 'estadoinasistenciaxparte';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
       
        $scenarios[self::SCENARIO_COMISONREG] = ['estadoinasistencia', 'detalle', 'falta'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estadoinasistencia', 'fecha', 'detalleparte', 'falta'], 'required'],
            [['falta', 'detalle'], 'required', 'on'=>self::SCENARIO_COMISONREG],
            [['estadoinasistencia', 'detalleparte', 'falta'], 'integer'],
            [['fecha'], 'safe'],
            [['detalle'], 'string', 'max' => 100],
            [['detalleparte'], 'exist', 'skipOnError' => true, 'targetClass' => Detalleparte::className(), 'targetAttribute' => ['detalleparte' => 'id']],
            [['estadoinasistencia'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoinasistencia::className(), 'targetAttribute' => ['estadoinasistencia' => 'id']],
            [['falta'], 'exist', 'skipOnError' => true, 'targetClass' => Falta::className(), 'targetAttribute' => ['falta' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'detalle' => 'Detalle',
            'estadoinasistencia' => 'Estadoinasistencia',
            'fecha' => 'Fecha',
            'detalleparte' => 'Detalleparte',
            'falta' => 'Falta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleparte0()
    {
        return $this->hasOne(Detalleparte::className(), ['id' => 'detalleparte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoinasistencia0()
    {
        return $this->hasOne(Estadoinasistencia::className(), ['id' => 'estadoinasistencia']);
    }

    public function getFalta0()
    {
        return $this->hasOne(Falta::className(), ['id' => 'falta']);
    }
}
