<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "certificacionedh".
 *
 * @property int $id
 * @property string $contacto
 * @property string $diagnostico
 * @property string $fecha
 * @property string $indicacion
 * @property string $institucion
 * @property string $referente
 * @property int $solicitud
 * @property int $tipocertificado
 * @property int $tipoprofesional
 *
 * @property Adjuntocertificacion[] $adjuntocertificacions
 * @property Solicitudedh $solicitud0
 * @property Tipocertificacion $tipocertificado0
 * @property Tipoprofesional $tipoprofesional0
 */
class Certificacionedh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'certificacionedh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha','vencimiento'], 'safe'],
            [['indicacion'], 'string'],
            [['referente', 'solicitud', 'fecha'], 'required'],
            [['solicitud', 'tipocertificado', 'tipoprofesional'], 'integer'],
            [['contacto', 'institucion', 'referente'], 'string', 'max' => 150],
            [['diagnostico'], 'string', 'max' => 350],
            [['solicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitudedh::className(), 'targetAttribute' => ['solicitud' => 'id']],
            [['tipocertificado'], 'exist', 'skipOnError' => true, 'targetClass' => Tipocertificacion::className(), 'targetAttribute' => ['tipocertificado' => 'id']],
            [['tipoprofesional'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoprofesional::className(), 'targetAttribute' => ['tipoprofesional' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contacto' => 'Contacto',
            'diagnostico' => 'Diagnóstico',
            'fecha' => 'Fecha',
            'indicacion' => 'Indicación',
            'institucion' => 'Institución',
            'referente' => 'Referente de salud',
            'solicitud' => 'Solicitud',
            'tipocertificado' => 'Tipo',
            'tipoprofesional' => 'Area profesional',
            'vencimiento' => 'Vencimiento',
        ];
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdjuntocertificacions()
    {
        return $this->hasMany(Adjuntocertificacion::className(), ['certificacion' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitud0()
    {
        return $this->hasOne(Solicitudedh::className(), ['id' => 'solicitud']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipocertificado0()
    {
        return $this->hasOne(Tipocertificacion::className(), ['id' => 'tipocertificado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoprofesional0()
    {
        return $this->hasOne(Tipoprofesional::className(), ['id' => 'tipoprofesional']);
    }
}
