<?php

namespace app\modules\edh\models;

use app\models\Agente;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\Tutor;
use Yii;

/**
 * This is the model class for table "actorxactuacion".
 *
 * @property int $id
 * @property string $persona
 * @property int $actuacion
 *
 * @property Actuacionedh $actuacion0
 */
class Actorxactuacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actorxactuacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['persona', 'actuacion'], 'required'],
            [['actuacion'], 'integer'],
            [['persona'], 'safe'],
            [['actuacion'], 'exist', 'skipOnError' => true, 'targetClass' => Actuacionedh::className(), 'targetAttribute' => ['actuacion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'persona' => 'Actores',
            'actuacion' => 'Actuacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActuacion0()
    {
        return $this->hasOne(Actuacionedh::className(), ['id' => 'actuacion']);
    }

    public function getPersona0()
    {
        $agente = Agente::find()->where(['documento' => $this->persona])->one();
        if($agente != null)
            return $this->hasOne(Agente::className(), ['documento' => 'persona']);

        $alumno = Alumno::find()->where(['documento' => $this->persona])->one();
        if($alumno != null)
            return $this->hasOne(Alumno::className(), ['documento' => 'persona']);

        $tutor = Tutor::find()->where(['documento' => $this->persona])->one();    
        if($tutor != null)
            return $this->hasOne(Tutor::className(), ['documento' => 'persona']);

        
    }
}
