<?php

namespace app\modules\edh\models;


use Yii;
use app\models\Agente;

/**
 * This is the model class for table "informeprofesional".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $fecha
 * @property int $areasolicitud
 * @property int $agente
 * @property int $caso
 *
 * @property Areasolicitud $areasolicitud0
 * @property Agente $agente0
 * @property Caso $caso0
 */
class Informeprofesional extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'informeprofesional';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'fecha', 'agente', 'caso'], 'required'],
            [['descripcion'], 'string'],
            [['fecha'], 'safe'],
            [['areasolicitud', 'agente', 'caso'], 'integer'],
            [['areasolicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Areasolicitud::className(), 'targetAttribute' => ['areasolicitud' => 'id']],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['caso'], 'exist', 'skipOnError' => true, 'targetClass' => Caso::className(), 'targetAttribute' => ['caso' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'fecha' => 'Fecha',
            'areasolicitud' => 'Areasolicitud',
            'agente' => 'Agente',
            'caso' => 'Caso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreasolicitud0()
    {
        return $this->hasOne(Areasolicitud::className(), ['id' => 'areasolicitud']);
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
    public function getCaso0()
    {
        return $this->hasOne(Caso::className(), ['id' => 'caso']);
    }
}
