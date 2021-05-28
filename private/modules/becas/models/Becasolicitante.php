<?php

namespace app\modules\becas\models;


use Yii;
use app\models\Parentesco;

/**
 * This is the model class for table "becasolicitante".
 *
 * @property int $id
 * @property string $apellido
 * @property string $nombre
 * @property string $cuil
 * @property string $mail
 * @property string $telefono
 * @property string $fechanac
 * @property string $domicilio
 * @property int $parentesco
 * @property int $nivelestudio
 * @property int $negativaanses
 * @property int $persona
 *
 * @property Becanegativaanses $negativaanses0
 * @property Becanivelestudio $nivelestudio0
 * @property Parentesco $parentesco0
 * @property Becapersona $persona0
 * @property Becasolicitud[] $becasolicituds
 */
class Becasolicitante extends \yii\db\ActiveRecord
{
    public $ocupaciones;
    public $ayudas;
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becasolicitante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido', 'nombre', 'cuil', 'mail', 'telefono', 'fechanac', 'domicilio', 'parentesco', 'nivelestudio', 'persona', 'ocupaciones', 'ayudas', 'conviviente'], 'required'],
            [['fechanac'], 'safe'],
            [['image'], 'file', 'maxSize'=>'1048576', 'extensions' => 'png, jpg, jpeg, pdf'],
            [['parentesco', 'nivelestudio', 'negativaanses', 'persona', 'conviviente'], 'integer'],
            [['apellido', 'nombre', 'mail'], 'string', 'max' => 150],
            [['cuil'], 'string', 'max' => 13],
            [['cuil'], 'string', 'min' => 13],
            [['telefono'], 'string', 'max' => 50],
            [['domicilio'], 'string', 'max' => 300],
            ['mail', 'email'],
            [['negativaanses'], 'exist', 'skipOnError' => true, 'targetClass' => Becanegativaanses::className(), 'targetAttribute' => ['negativaanses' => 'id']],
            [['nivelestudio'], 'exist', 'skipOnError' => true, 'targetClass' => Becanivelestudio::className(), 'targetAttribute' => ['nivelestudio' => 'id']],
            [['parentesco'], 'exist', 'skipOnError' => true, 'targetClass' => Parentesco::className(), 'targetAttribute' => ['parentesco' => 'id']],
            [['persona'], 'exist', 'skipOnError' => true, 'targetClass' => Becapersona::className(), 'targetAttribute' => ['persona' => 'id']],
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
            'mail' => 'Correo electrónico',
            'telefono' => 'Teléfono',
            'fechanac' => 'Fecha de nacimiento',
            'domicilio' => 'Domicilio',
            'nivelestudio' => 'Nivel de estudio',
            'negativaanses' => 'Negativa de anses',
            'ocupaciones' => 'Condición ocupacional',
            'ayudas' => 'Ayuda económica estatal',
            'persona' => 'Persona',
            'image' => 'Negativa de anses',
            'parentesco' => 'Parentesco',
            'conviviente' => 'Convive con el/la estudiante'
            
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
    public function getBecasolicituds()
    {
        return $this->hasMany(Becasolicitud::className(), ['solicitante' => 'id']);
    }
}
