<?php

namespace app\modules\sociocomunitarios\models;


use Yii;
use app\modules\curriculares\models\Comision;

/**
 * This is the model class for table "actividadpsc".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $comision
 * @property string $fecha
 *
 * @property Comision $comision0
 * @property Detalleactividadpsc[] $detalleactividadpscs
 */
class Actividadpsc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actividadpsc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'comision', 'fecha'], 'required'],
            [['comision'], 'integer'],
            [['fecha'], 'safe'],
            [['descripcion'], 'string', 'max' => 400],
            [['comision'], 'exist', 'skipOnError' => true, 'targetClass' => Comision::className(), 'targetAttribute' => ['comision' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripción de la actividad',
            'comision' => 'Comision',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComision0()
    {
        return $this->hasOne(Comision::className(), ['id' => 'comision']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleactividadpscs()
    {
        return $this->hasMany(Detalleactividadpsc::className(), ['actividad' => 'id']);
    }
}
