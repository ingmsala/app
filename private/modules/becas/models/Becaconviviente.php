<?php

namespace app\modules\becas\models;


use Yii;
use app\models\Parentesco;

/**
 * This is the model class for table "becaconviviente".
 *
 * @property int $id
 * @property string $apellido
 * @property string $nombre
 * @property string $cuil
 * @property string $fechanac
 * @property int $nivelestudio
 * @property int $negativaanses
 * @property int $parentesco
 * @property int $solicitud
 * @property int $persona
 *
 * @property Becanegativaanses $negativaanses0
 * @property Becanivelestudio $nivelestudio0
 * @property Parentesco $parentesco0
 * @property Becapersona $persona0
 * @property Becasolicitud $solicitud0
 */
class Becaconviviente extends \yii\db\ActiveRecord
{
    public $ocupaciones;
    public $ayudas;
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becaconviviente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido', 'nombre', 'cuil', 'fechanac', 'nivelestudio', 'parentesco', 'solicitud', 'persona', 'ocupaciones', 'ayudas'], 'required'],
            [['fechanac'], 'safe'],
            [['image'], 'file', 'maxSize'=>'1048576', 'extensions' => 'png, jpg, jpeg, pdf'],
            [['nivelestudio', 'negativaanses', 'parentesco', 'solicitud', 'persona'], 'integer'],
            [['apellido', 'nombre'], 'string', 'max' => 150],
            [['cuil'], 'string', 'max' => 13],
            [['cuil'], 'string', 'min' => 13],
            [['negativaanses'], 'exist', 'skipOnError' => true, 'targetClass' => Becanegativaanses::className(), 'targetAttribute' => ['negativaanses' => 'id']],
            [['nivelestudio'], 'exist', 'skipOnError' => true, 'targetClass' => Becanivelestudio::className(), 'targetAttribute' => ['nivelestudio' => 'id']],
            [['parentesco'], 'exist', 'skipOnError' => true, 'targetClass' => Parentesco::className(), 'targetAttribute' => ['parentesco' => 'id']],
            [['persona'], 'exist', 'skipOnError' => true, 'targetClass' => Becapersona::className(), 'targetAttribute' => ['persona' => 'id']],
            [['solicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Becasolicitud::className(), 'targetAttribute' => ['solicitud' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'apellido' => 'Apellidos',
            'nombre' => 'Nombres',
            'cuil' => 'CUIL',
            'fechanac' => 'Fecha de nacimiento',
            'nivelestudio' => 'Nivel de estudio',
            'negativaanses' => 'Negativa de Anses',
            'parentesco' => 'Parentesco',
            'solicitud' => 'Solicitud',
            'ocupaciones' => 'Condición ocupacional',
            'ayudas' => 'Ayuda económica estatal',
            'persona' => 'Persona',
            'image' => 'Negativa de anses',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNegativaanses0()
    {
        return $this->hasOne(Becanegativaanses::className(), ['id' => 'negativaanses']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNivelestudio0()
    {
        return $this->hasOne(Becanivelestudio::className(), ['id' => 'nivelestudio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentesco0()
    {
        return $this->hasOne(Parentesco::className(), ['id' => 'parentesco']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersona0()
    {
        return $this->hasOne(Becapersona::className(), ['id' => 'persona']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitud0()
    {
        return $this->hasOne(Becasolicitud::className(), ['id' => 'solicitud']);
    }
}
