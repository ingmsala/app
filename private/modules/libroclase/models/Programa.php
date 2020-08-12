<?php

namespace app\modules\libroclase\models;

use app\models\Actividad;
use app\models\Plan;
use Yii;

/**
 * This is the model class for table "programa".
 *
 * @property int $id
 * @property int $plan
 * @property int $actividad
 * @property int $vigencia
 * @property string $version
 *
 * @property Detalleunidad[] $detalleunidads
 * @property Actividad $actividad0
 */
class Programa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'programa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['plan', 'actividad', 'vigencia'], 'integer'],
            [['actividad', 'vigencia'], 'required'],
            [['version'], 'string', 'max' => 50],
            [['actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::className(), 'targetAttribute' => ['actividad' => 'id']],
            [['plan'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plan' => 'Plan de estudios',
            'actividad' => 'Actividad',
            'vigencia' => 'Vigencia',
            'version' => 'Versión',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleunidads()
    {
        return $this->hasMany(Detalleunidad::className(), ['programa' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividad0()
    {
        return $this->hasOne(Actividad::className(), ['id' => 'actividad']);
    }
    public function getPlan0()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan']);
    }
}
