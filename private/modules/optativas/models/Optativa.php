<?php

namespace app\modules\optativas\models;


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
 * @property Areaoptativa $areaoptativa0
 */
class Optativa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optativa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actividad', 'aniolectivo', 'areaoptativa'], 'required'],
            [['actividad', 'aniolectivo', 'duracion', 'areaoptativa'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComisions()
    {
        return $this->hasMany(Comision::className(), ['optativa' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatriculas()
    {
        return $this->hasMany(Matricula::className(), ['optativa' => 'id']);
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
