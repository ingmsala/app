<?php

namespace app\modules\mones\models;

use Yii;

/**
 * This is the model class for table "monmateria".
 *
 * @property string $id
 * @property string $nombre
 * @property string $codmon
 * @property int $carrera
 *
 * @property Monacademica[] $monacademicas
 * @property Moncarrera $carrera0
 */
class Monmateria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'monmateria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['carrera'], 'integer'],
            [['id'], 'string', 'max' => 7],
            [['nombre'], 'string', 'max' => 100],
            [['codmon'], 'string', 'max' => 4],
            [['id'], 'unique'],
            [['carrera'], 'exist', 'skipOnError' => true, 'targetClass' => Moncarrera::className(), 'targetAttribute' => ['carrera' => 'id']],
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
            'codmon' => 'Codmon',
            'carrera' => 'Carrera',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonacademicas()
    {
        return $this->hasMany(Monacademica::className(), ['materia' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarrera0()
    {
        return $this->hasOne(Moncarrera::className(), ['id' => 'carrera']);
    }
}
