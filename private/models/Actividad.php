<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividad".
 *
 * @property int $id
 * @property string $nombre
 * @property int $cantHoras
 * @property int $actividadtipo
 * @property int $plan
 * @property int $propuesta
 *
 * @property Plan $plan0
 * @property Actividadtipo $actividadtipo0
 * @property Propuesta $propuesta0
 * @property Catedra[] $catedras
 */
class Actividad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'cantHoras', 'actividadtipo', 'propuesta'], 'required'],
            [['cantHoras', 'actividadtipo', 'plan', 'propuesta'], 'integer'],
            [['nombre'], 'string', 'max' => 70],
            [['plan'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan' => 'id']],
            [['actividadtipo'], 'exist', 'skipOnError' => true, 'targetClass' => Actividadtipo::className(), 'targetAttribute' => ['actividadtipo' => 'id']],
            [['propuesta'], 'exist', 'skipOnError' => true, 'targetClass' => Propuesta::className(), 'targetAttribute' => ['propuesta' => 'id']],
            [['propuesta', 'nombre', 'plan'], 'unique', 'targetClass' => '\app\models\Actividad', 'targetAttribute' => ['propuesta', 'nombre', 'plan'], 'message' => 'Ya existe la actividad en esa Propuesta y en ese Plan de Estudios.'],
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
            'cantHoras' => 'Cantidad de Horas',
            'actividadtipo' => 'Tipo de Actividad',
            'plan' => 'Plan de Estudio',
            'propuesta' => 'Propuesta Formativa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan0()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividadtipo0()
    {
        return $this->hasOne(Actividadtipo::className(), ['id' => 'actividadtipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropuesta0()
    {
        return $this->hasOne(Propuesta::className(), ['id' => 'propuesta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatedras()
    {
        return $this->hasMany(Catedra::className(), ['actividad' => 'id']);
    }
}
