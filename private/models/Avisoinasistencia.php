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
 * @property Docente $docente0
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
            [['docente'], 'integer'],
            [['desde', 'hasta'], 'safe'],
            [['docente'], 'exist', 'skipOnError' => true, 'targetClass' => Docente::className(), 'targetAttribute' => ['docente' => 'id']],
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
            'docente' => 'Docente',
            'desde' => 'Desde',
            'hasta' => 'Hasta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocente0()
    {
        return $this->hasOne(Docente::className(), ['id' => 'docente']);
    }
}
