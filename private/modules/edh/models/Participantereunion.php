<?php

namespace app\modules\edh\models;

use app\models\Agente;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\Tutor;
use Yii;

/**
 * This is the model class for table "participantereunion".
 *
 * @property int $id
 * @property string $participante
 * @property int $reunionedh
 * @property int $tipoparticipante
 * @property int $asistio
 * @property int $comunico
 *
 * @property Reunionedh $reunionedh0
 * @property Tipoparticipante $tipoparticipante0
 */
class Participantereunion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'participantereunion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $agente = Agente::find()->where(['documento' => $this->participante])->one();
        if($agente != null)
            $arr = [['participante'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['participante' => 'documento']];

        $alumno = Alumno::find()->where(['documento' => $this->participante])->one();
        if($alumno != null)
            $arr = [['participante'], 'exist', 'skipOnError' => true, 'targetClass' => Alumno::className(), 'targetAttribute' => ['participante' => 'documento']];

        $tutor = Tutor::find()->where(['documento' => $this->participante])->one();    
        if($tutor != null)
            $arr = [['participante'], 'exist', 'skipOnError' => true, 'targetClass' => Tutor::className(), 'targetAttribute' => ['participante' => 'documento']];

        return [
            [['participante', 'reunionedh', 'tipoparticipante', 'asistio', 'comunico'], 'required'],
            [['reunionedh', 'tipoparticipante', 'asistio', 'comunico'], 'integer'],
            [['participante'], 'string', 'max' => 8],
            [['reunionedh'], 'exist', 'skipOnError' => true, 'targetClass' => Reunionedh::className(), 'targetAttribute' => ['reunionedh' => 'id']],
            [['tipoparticipante'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoparticipante::className(), 'targetAttribute' => ['tipoparticipante' => 'id']],
            //$arr
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'participante' => 'Participante',
            'reunionedh' => 'Reunionedh',
            'tipoparticipante' => 'Tipoparticipante',
            'asistio' => 'Asistio',
            'comunico' => 'Comunico',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipante0()
    {
        $agente = Agente::find()->where(['documento' => $this->participante])->one();
        if($agente != null)
            return $this->hasOne(Agente::className(), ['documento' => 'participante']);

        $alumno = Alumno::find()->where(['documento' => $this->participante])->one();
        if($alumno != null)
            return $this->hasOne(Alumno::className(), ['documento' => 'participante']);

        $tutor = Tutor::find()->where(['documento' => $this->participante])->one();    
        if($tutor != null)
            return $this->hasOne(Tutor::className(), ['documento' => 'participante']);

        
    }

    public function getReunionedh0()
    {
        return $this->hasOne(Reunionedh::className(), ['id' => 'reunionedh']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoparticipante0()
    {
        return $this->hasOne(Tipoparticipante::className(), ['id' => 'tipoparticipante']);
    }
}
