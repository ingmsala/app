<?php

namespace app\modules\becas\models;

use Yii;

/**
 * This is the model class for table "becasolicitud".
 *
 * @property int $id
 * @property string $fecha
 * @property int $solicitante
 * @property int $convocatoria
 * @property int $estado
 * @property int $estudiante
 * @property string $token
 *
 * @property Becaconviviente[] $becaconvivientes
 * @property Becaestadoxsolicitud[] $becaestadoxsolicituds
 * @property Becaconvocatoria $convocatoria0
 * @property Becaestadosolicitud $estado0
 * @property Becaalumno $estudiante0
 * @property Becasolicitante $solicitante0
 */
class Becasolicitud extends \yii\db\ActiveRecord
{
    public $divisiones;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becasolicitud';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'solicitante', 'convocatoria', 'estado', 'estudiante', 'token'], 'required'],
            [['fecha'], 'safe'],
            [['puntaje'], 'number'],
            [['solicitante', 'convocatoria', 'estado', 'estudiante'], 'integer'],
            [['token'], 'string', 'max' => 24],
            [['convocatoria'], 'exist', 'skipOnError' => true, 'targetClass' => Becaconvocatoria::className(), 'targetAttribute' => ['convocatoria' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Becaestadosolicitud::className(), 'targetAttribute' => ['estado' => 'id']],
            [['estudiante'], 'exist', 'skipOnError' => true, 'targetClass' => Becaalumno::className(), 'targetAttribute' => ['estudiante' => 'id']],
            [['solicitante'], 'exist', 'skipOnError' => true, 'targetClass' => Becasolicitante::className(), 'targetAttribute' => ['solicitante' => 'id']],
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
            'solicitante' => 'Solicitante',
            'convocatoria' => 'Convocatoria',
            'estado' => 'Estado',
            'estudiante' => 'Estudiante',
            'token' => 'Token',
            'puntaje' => 'Puntaje',
            'division' => 'División',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecaconvivientes()
    {
        return $this->hasMany(Becaconviviente::className(), ['solicitud' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecaestadoxsolicituds()
    {
        return $this->hasMany(Becaestadoxsolicitud::className(), ['solicitud' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConvocatoria0()
    {
        return $this->hasOne(Becaconvocatoria::className(), ['id' => 'convocatoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Becaestadosolicitud::className(), ['id' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiante0()
    {
        return $this->hasOne(Becaalumno::className(), ['id' => 'estudiante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitante0()
    {
        return $this->hasOne(Becasolicitante::className(), ['id' => 'solicitante']);
    }
}
