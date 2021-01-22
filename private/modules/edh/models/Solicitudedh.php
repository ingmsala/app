<?php

namespace app\modules\edh\models;

use app\modules\curriculares\models\Tutor;
use Yii;

/**
 * This is the model class for table "solicitudedh".
 *
 * @property int $id
 * @property string $fecha
 * @property int $areasolicitud
 * @property int $caso
 * @property int $demandante
 * @property int $estadosolicitud
 * @property int $tiposolicitud
 *
 * @property Areasolicitud $areasolicitud0
 * @property Caso $caso0
 * @property Tutor $demandante0
 * @property Tiposolicitud $tiposolicitud0
 */
class Solicitudedh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solicitudedh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'areasolicitud', 'caso', 'estadosolicitud', 'tiposolicitud'], 'required'],
            [['fecha', 'fechaexpediente'], 'safe'],
            [['expediente'], 'string', 'max' => 100],
            [['areasolicitud', 'caso', 'demandante', 'estadosolicitud', 'tiposolicitud'], 'integer'],
            [['areasolicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Areasolicitud::className(), 'targetAttribute' => ['areasolicitud' => 'id']],
            [['caso'], 'exist', 'skipOnError' => true, 'targetClass' => Caso::className(), 'targetAttribute' => ['caso' => 'id']],
            [['demandante'], 'exist', 'skipOnError' => true, 'targetClass' => Tutor::className(), 'targetAttribute' => ['demandante' => 'id']],
            [['tiposolicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Tiposolicitud::className(), 'targetAttribute' => ['tiposolicitud' => 'id']],
            [['estadosolicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Estadosolicitud::className(), 'targetAttribute' => ['estadosolicitud' => 'id']],
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
            'areasolicitud' => 'Área de recepción',
            'caso' => 'Caso',
            'demandante' => 'Demandante',
            'estadosolicitud' => 'Estado de solicitud',
            'tiposolicitud' => 'Tipo de solicitud',
            'fechaexpediente' => 'Fecha del expediente',
            'expediente' => 'Expediente',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreasolicitud0()
    {
        return $this->hasOne(Areasolicitud::className(), ['id' => 'areasolicitud']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaso0()
    {
        return $this->hasOne(Caso::className(), ['id' => 'caso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDemandante0()
    {
        return $this->hasOne(Tutor::className(), ['id' => 'demandante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposolicitud0()
    {
        return $this->hasOne(Tiposolicitud::className(), ['id' => 'tiposolicitud']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadosolicitud0()
    {
        return $this->hasOne(Estadosolicitud::className(), ['id' => 'estadosolicitud']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertificacionedhs()
    {
        return $this->hasMany(Certificacionedh::className(), ['solicitud' => 'id']);
    }
}
