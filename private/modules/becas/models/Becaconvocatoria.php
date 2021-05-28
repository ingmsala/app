<?php

namespace app\modules\becas\models;


use Yii;
use app\modules\curriculares\models\Aniolectivo;

/**
 * This is the model class for table "becaconvocatoria".
 *
 * @property int $id
 * @property int $aniolectivo
 * @property string $desde
 * @property string $hasta
 * @property int $becaconvocatoriaestado
 * @property int $becatipobeca
 *
 * @property Aniolectivo $aniolectivo0
 * @property Becaconvocatoriaestado $becaconvocatoriaestado0
 * @property Becatipobeca $becatipobeca0
 * @property Becasolicitud[] $becasolicituds
 */
class Becaconvocatoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becaconvocatoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aniolectivo', 'desde', 'hasta', 'becaconvocatoriaestado', 'becatipobeca'], 'required'],
            [['aniolectivo', 'becaconvocatoriaestado', 'becatipobeca'], 'integer'],
            [['desde', 'hasta'], 'safe'],
            [['aniolectivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aniolectivo::className(), 'targetAttribute' => ['aniolectivo' => 'id']],
            [['becaconvocatoriaestado'], 'exist', 'skipOnError' => true, 'targetClass' => Becaconvocatoriaestado::className(), 'targetAttribute' => ['becaconvocatoriaestado' => 'id']],
            [['becatipobeca'], 'exist', 'skipOnError' => true, 'targetClass' => Becatipobeca::className(), 'targetAttribute' => ['becatipobeca' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aniolectivo' => 'Aniolectivo',
            'desde' => 'Desde',
            'hasta' => 'Hasta',
            'becaconvocatoriaestado' => 'Becaconvocatoriaestado',
            'becatipobeca' => 'Becatipobeca',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAniolectivo0()
    {
        return $this->hasOne(Aniolectivo::className(), ['id' => 'aniolectivo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecaconvocatoriaestado0()
    {
        return $this->hasOne(Becaconvocatoriaestado::className(), ['id' => 'becaconvocatoriaestado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecatipobeca0()
    {
        return $this->hasOne(Becatipobeca::className(), ['id' => 'becatipobeca']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecasolicituds()
    {
        return $this->hasMany(Becasolicitud::className(), ['convocatoria' => 'id']);
    }
}
