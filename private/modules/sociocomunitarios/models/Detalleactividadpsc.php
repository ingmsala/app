<?php

namespace app\modules\sociocomunitarios\models;

use Yii;

/**
 * This is the model class for table "detalleactividadpsc".
 *
 * @property int $id
 * @property int $actividad
 * @property int $matricula
 * @property int $presentacion
 * @property int $calificacion
 *
 * @property Actividadpsc $actividad0
 * @property Calificacionactpsc $calificacion0
 * @property Presentacionactivpsc $presentacion0
 */
class Detalleactividadpsc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalleactividadpsc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actividad', 'matricula'], 'required'],
            [['actividad', 'matricula', 'presentacion', 'calificacion'], 'integer'],
            [['actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividadpsc::className(), 'targetAttribute' => ['actividad' => 'id']],
            [['calificacion'], 'exist', 'skipOnError' => true, 'targetClass' => Calificacionactpsc::className(), 'targetAttribute' => ['calificacion' => 'id']],
            [['presentacion'], 'exist', 'skipOnError' => true, 'targetClass' => Presentacionactivpsc::className(), 'targetAttribute' => ['presentacion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'actividad' => 'Actividad',
            'matricula' => 'Matricula',
            'presentacion' => 'Presentacion',
            'calificacion' => 'Calificacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividad0()
    {
        return $this->hasOne(Actividadpsc::className(), ['id' => 'actividad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacion0()
    {
        return $this->hasOne(Calificacionactpsc::className(), ['id' => 'calificacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresentacion0()
    {
        return $this->hasOne(Presentacionactivpsc::className(), ['id' => 'presentacion']);
    }
}
