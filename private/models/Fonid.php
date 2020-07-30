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
 * @property Docente $docente0
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
        $scenarios[self::SCENARIO_SEARCHINDEX] = ['hasta', 'docente'];
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
            [['docente', 'estadofonid'], 'integer'],
            [['fecha'], 'safe'],
            [['docente'], 'exist', 'skipOnError' => true, 'targetClass' => Docente::className(), 'targetAttribute' => ['docente' => 'id']],
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
            'docente' => 'Docente',
            'fecha' => 'Fecha',
            'estadofonid' => 'Estadofonid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocente0()
    {
        return $this->hasOne(Docente::className(), ['id' => 'docente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadofon()
    {
        return $this->hasOne(Estadodj::className(), ['id' => 'estadofonid']);
    }
}
