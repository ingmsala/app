<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "expediente".
 *
 * @property int $id
 * @property string $fecha
 * @property string $numero
 * @property int $solicitud
 */
class Expediente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expediente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha'], 'safe'],
            [['solicitud'], 'required'],
            [['solicitud'], 'integer'],
            [['numero'], 'string', 'max' => 150],
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
            'numero' => 'Numero',
            'solicitud' => 'Solicitud',
        ];
    }
}
