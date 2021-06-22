<?php

namespace app\modules\becas\models;

use app\modules\curriculares\models\Alumno;
use Yii;

/**
 * This is the model class for table "becaalumno".
 *
 * @property int $id
 * @property string $apellido
 * @property string $nombre
 * @property string $cuil
 * @property string $mail
 * @property string $telefono
 * @property string $fechanac
 * @property string $domicilio
 * @property int $nivelestudio
 * @property int $negativaanses
 * @property int $persona
 *
 * @property Becanegativaanses $negativaanses0
 * @property Becanivelestudio $nivelestudio0
 * @property Becapersona $persona0
 * @property Becasolicitud[] $becasolicituds
 */
class Becaalumno extends \yii\db\ActiveRecord
{
    public $ocupaciones;
    public $ayudas;
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becaalumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido', 'nombre', 'cuil', 'fechanac', 'domicilio', 'nivelestudio', 'persona', 'ocupaciones', 'ayudas'], 'required'],
            [['fechanac'], 'safe'],
            [['image'], 'file', 'maxSize'=>'1048576', 'extensions' => 'png, jpg, jpeg, pdf'],
            ['mail', 'email'],
            [['nivelestudio', 'negativaanses', 'persona', 'alumno'], 'integer'],
            [['apellido', 'nombre', 'mail'], 'string', 'max' => 150],
            [['cuil'], 'string', 'max' => 13],
            [['cuil'], 'string', 'min' => 13],
            [['telefono'], 'string', 'max' => 50],
            [['domicilio'], 'string', 'max' => 300],
            [['negativaanses'], 'exist', 'skipOnError' => true, 'targetClass' => Becanegativaanses::className(), 'targetAttribute' => ['negativaanses' => 'id']],
            [['nivelestudio'], 'exist', 'skipOnError' => true, 'targetClass' => Becanivelestudio::className(), 'targetAttribute' => ['nivelestudio' => 'id']],
            [['persona'], 'exist', 'skipOnError' => true, 'targetClass' => Becapersona::className(), 'targetAttribute' => ['persona' => 'id']],
            [['alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumno::className(), 'targetAttribute' => ['alumno' => 'id']],
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
    public function getPersona0()
    {
        return $this->hasOne(Becapersona::className(), ['id' => 'persona']);
    }

    public function getAlumno0()
    {
        $dni = substr($this->cuil, 3, -2);
        return Alumno::find()->where(['documento' => $dni])->one();
    }
    public function getAlumnos0()
    {
        
        return $this->hasOne(Alumno::className(), ['id' => 'alumno']);
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecasolicituds()
    {
        return $this->hasMany(Becasolicitud::className(), ['estudiante' => 'id']);
    }
}
