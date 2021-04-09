<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipoavisoparte".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Avisoinasistencia[] $avisoinasistencias
 */
class Tipoavisoparte extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipoavisoparte';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvisoinasistencias()
    {
        return $this->hasMany(Avisoinasistencia::className(), ['tipoavisoparte' => 'id']);
    }
}
