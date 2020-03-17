<?php

namespace app\modules\curriculares\models;


use Yii;
use app\models\Actividad;

/**
 * This is the model class for table "optativa".
 *
 * @property int $id
 * @property int $actividad
 * @property int $aniolectivo
 *
 * @property Comision[] $comisions
 * @property Matricula[] $matriculas
 * @property Actividad $actividad0
 * @property Aniolectivo $aniolectivo0
 * @property Areaoptativa $areaespaciocurricular0
 */
class Espaciocurricular extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'espaciocurricular';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actividad', 'aniolectivo', 'areaoptativa', 'curso', 'tipoespacio'], 'required'],
            [['actividad', 'aniolectivo', 'duracion', 'areaoptativa', 'curso', 'tipoespacio'], 'integer'],
            [['resumen'], 'string'], 
            
            [['actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::className(), 'targetAttribute' => ['actividad' => 'id']],
            [['aniolectivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aniolectivo::className(), 'targetAttribute' => ['aniolectivo' => 'id']],
            [['areaoptativa'], 'exist', 'skipOnError' => true, 'targetClass' => Areaoptativa::className(), 'targetAttribute' => ['areaoptativa' => 'id']],
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
            'aniolectivo' => 'Año Lectivo',
            'duracion' => 'Duración (horas)',
            'areaoptativa' => 'Area de optativa',
            'curso' => 'Curso',
            'resumen' => 'Resumen', 
            'tipoespacio' => 'Tipo de Espacio', 
            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComisions()
    {
        return $this->hasMany(Comision::className(), ['espaciocurricular' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatriculas()
    {
        return $this->hasMany(Matricula::className(), ['espaciocurricular' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividad0()
    {
        return $this->hasOne(Actividad::className(), ['id' => 'actividad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAniolectivo0()
    {
        return $this->hasOne(Aniolectivo::className(), ['id' => 'aniolectivo']);
    }

    public function getAreaoptativa0()
    {
        return $this->hasOne(Areaoptativa::className(), ['id' => 'areaoptativa']);
    }
}
