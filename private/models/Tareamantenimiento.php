<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tareamantenimiento".
 *
 * @property int $id
 * @property string $fecha
 * @property string $descripcion
 * @property int $responsable
 * @property int $estadotarea
 * @property int $novedadparte
 * @property int $prioridadtarea
 * @property string $fechafin
 *
 * @property Actividadesmantenimiento[] $actividadesmantenimientos
 * @property Estadotarea $estadotarea0
 * @property Novedadesparte $novedadparte0
 * @property Prioridadtarea $prioridadtarea0
 * @property Nodocente $responsable0
 */
class Tareamantenimiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tareamantenimiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'estadotarea', 'prioridadtarea'], 'required'],
            [['fecha', 'fechafin'], 'safe'],
            [['descripcion'], 'string'],
            [['responsable', 'estadotarea', 'novedadparte', 'prioridadtarea'], 'integer'],
            [['estadotarea'], 'exist', 'skipOnError' => true, 'targetClass' => Estadotarea::className(), 'targetAttribute' => ['estadotarea' => 'id']],
            [['novedadparte'], 'exist', 'skipOnError' => true, 'targetClass' => Novedadesparte::className(), 'targetAttribute' => ['novedadparte' => 'id']],
            [['prioridadtarea'], 'exist', 'skipOnError' => true, 'targetClass' => Prioridadtarea::className(), 'targetAttribute' => ['prioridadtarea' => 'id']],
            [['responsable'], 'exist', 'skipOnError' => true, 'targetClass' => Nodocente::className(), 'targetAttribute' => ['responsable' => 'id']],
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
            'descripcion' => 'Descripcion',
            'responsable' => 'Responsable',
            'estadotarea' => 'Estado',
            'novedadparte' => 'Novedadparte',
            'prioridadtarea' => 'Prioridad',
            'fechafin' => 'Fecha de fin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividadesmantenimientos()
    {
        return $this->hasMany(Actividadesmantenimiento::className(), ['tareamantenimiento' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadotarea0()
    {
        return $this->hasOne(Estadotarea::className(), ['id' => 'estadotarea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedadparte0()
    {
        return $this->hasOne(Novedadesparte::className(), ['id' => 'novedadparte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrioridadtarea0()
    {
        return $this->hasOne(Prioridadtarea::className(), ['id' => 'prioridadtarea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsable0()
    {
        return $this->hasOne(Nodocente::className(), ['id' => 'responsable']);
    }
}
