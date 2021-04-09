<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "avisoinasistencia".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $docente
 * @property string $desde
 * @property string $hasta
 *
 * @property Agente $agente0
 */
class Avisoinasistencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avisoinasistencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['hasta'], 'required', 'message' => 'Fecha de fin de la inasistencia o finalización de la visualización del aviso en el parte'],
            [['agente', 'tipoavisoparte'], 'integer'],
            [['desde', 'hasta'], 'safe'],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['tipoavisoparte'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoavisoparte::className(), 'targetAttribute' => ['tipoavisoparte' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Observaciones',
            'agente' => 'Agente',
            'desde' => 'Desde',
            'hasta' => 'Hasta',
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
    public function getTipoavisoparte0()
    {
        return $this->hasOne(Tipoavisoparte::className(), ['id' => 'tipoavisoparte']);
    }
}
