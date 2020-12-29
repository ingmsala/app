<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fonid".
 *
 * @property int $id
 * @property int $docente
 * @property string $fecha
 * @property int $estadofonid
 *
 * @property Agente $agente0
 * @property Estadodj $estadofon
 */
class Fonid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const SCENARIO_SEARCHINDEX = 'fonidadmin';
    public $hasta;


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCHINDEX] = ['hasta', 'agente'];
        return $scenarios;
    }


    public static function tableName()
    {
        return 'fonid';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'estadofonid'], 'required'],
            [['agente', 'estadofonid'], 'integer'],
            [['fecha'], 'safe'],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['estadofonid'], 'exist', 'skipOnError' => true, 'targetClass' => Estadodj::className(), 'targetAttribute' => ['estadofonid' => 'id']],
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
            'fecha' => 'Fecha',
            'estadofonid' => 'Estadofonid',
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
    public function getEstadofon()
    {
        return $this->hasOne(Estadodj::className(), ['id' => 'estadofonid']);
    }
}
