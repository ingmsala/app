<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadoxnovedad".
 *
 * @property int $id
 * @property int $novedadesparte
 * @property int $estadonovedad
 * @property string $fecha
 *
 * @property Novedadesparte $novedadesparte0
 * @property Estadonovedad $estadonovedad0
 */
class Estadoxnovedad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $trimestral;
    public $aniolectivo;
    public $finddescrip;
    public $preceptoria;
    
    public static function tableName()
    {
        return 'estadoxnovedad';
    }

    const FIND_NOVEDAD = 'filtro';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::FIND_NOVEDAD] = ['trimestral', 'aniolectivo', 'estadonovedad', 'finddescrip', 'preceptoria'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['novedadesparte', 'fecha'], 'required'],
            [['trimestral', 'aniolectivo', 'preceptoria'], 'required', 'message' => "Campo obligatorio", 'on'=>self::FIND_NOVEDAD],
            [['novedadesparte', 'estadonovedad', 'preceptoria'], 'integer'],
            [['fecha'], 'safe'],
            [['novedadesparte'], 'exist', 'skipOnError' => true, 'targetClass' => Novedadesparte::className(), 'targetAttribute' => ['novedadesparte' => 'id']],
            [['estadonovedad'], 'exist', 'skipOnError' => true, 'targetClass' => Estadonovedad::className(), 'targetAttribute' => ['estadonovedad' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'novedadesparte' => 'Novedadesparte',
            'estadonovedad' => 'Estadonovedad',
            'fecha' => 'Fecha',
            'preceptoria' => 'Preceptoría',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedadesparte0()
    {
        return $this->hasOne(Novedadesparte::className(), ['id' => 'novedadesparte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadonovedad0()
    {
        return $this->hasOne(Estadonovedad::className(), ['id' => 'estadonovedad']);
    }
}
