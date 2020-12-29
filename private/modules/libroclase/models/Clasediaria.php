<?php

namespace app\modules\libroclase\models;

use app\models\Catedra;
use app\models\Agente;
use Yii;

/**
 * This is the model class for table "clasediaria".
 *
 * @property int $id
 * @property int $catedra
 * @property int $temaunidad
 * @property int $tipodesarrollo
 * @property string $fecha
 * @property string $fechacarga
 * @property int $agente
 * @property string $observaciones
 * @property int $modalidadclase
 *
 * @property Catedra $catedra0
 * @property Tipodesarrollo $tipodesarrollo0
 * @property Agente $agente0
 * @property Temaunidad $temaunidad0
 * @property Modalidadclase $modalidadclase0
 * @property Detallehora[] $detallehoras
 */
class Clasediaria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clasediaria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catedra', 'temaunidad', 'tipodesarrollo', 'fecha', 'fechacarga'], 'required'],
            [['catedra', 'temaunidad', 'tipodesarrollo', 'agente', 'modalidadclase'], 'integer'],
            [['fecha', 'fechacarga'], 'safe'],
            [['observaciones'], 'string'],
            [['catedra'], 'exist', 'skipOnError' => true, 'targetClass' => Catedra::className(), 'targetAttribute' => ['catedra' => 'id']],
            [['tipodesarrollo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipodesarrollo::className(), 'targetAttribute' => ['tipodesarrollo' => 'id']],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['temaunidad'], 'exist', 'skipOnError' => true, 'targetClass' => Temaunidad::className(), 'targetAttribute' => ['temaunidad' => 'id']],
            [['modalidadclase'], 'exist', 'skipOnError' => true, 'targetClass' => Modalidadclase::className(), 'targetAttribute' => ['modalidadclase' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catedra' => 'Cátedra',
            'temaunidad' => 'Tema de unidad',
            'tipodesarrollo' => 'Tipo de desarrollo',
            'fecha' => 'Fecha',
            'fechacarga' => 'Fecha de carga',
            'agente' => 'Agente',
            'observaciones' => 'Observaciones',
            'modalidadclase' => 'Modalidad de clase',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatedra0()
    {
        return $this->hasOne(Catedra::className(), ['id' => 'catedra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipodesarrollo0()
    {
        return $this->hasOne(Tipodesarrollo::className(), ['id' => 'tipodesarrollo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgente0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'agente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemaunidad0()
    {
        return $this->hasOne(Temaunidad::className(), ['id' => 'temaunidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModalidadclase0()
    {
        return $this->hasOne(Modalidadclase::className(), ['id' => 'modalidadclase']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallehoras()
    {
        return $this->hasMany(Detallehora::className(), ['clasediaria' => 'id']);
    }
}
