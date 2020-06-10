<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nodocente".
 *
 * @property int $id
 * @property string $legajo
 * @property string $apellido
 * @property string $nombre
 * @property int $genero
 * @property string $documento
 * @property string $mail 

 * @property Tareamantenimiento[] $tareamantenimientos
 */
class Nodocente extends \yii\db\ActiveRecord
{

    const SCENARIO_DECLARACIONJURADA = 'declaracionjurada';
   

    

    public function scenarios()
    {
       $scenarios = parent::scenarios();
       $scenarios[self::SCENARIO_DECLARACIONJURADA] = ['apellido', 'nombre', 'legajo', 'documento', 'tipodocumento', 'mail', 'telefono', 'fechanac', 'cuil', 'domicilio', 'localidad'];
        
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nodocente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido', 'nombre', 'genero', 'condicionnodocente', 'mail'], 'required'],
            [['apellido', 'nombre', 'legajo', 'documento', 'tipodocumento', 'mail', 'telefono', 'fechanac', 'cuil', 'domicilio', 'localidad'], 'required', 'on' => self::SCENARIO_DECLARACIONJURADA],
            [['genero', 'condicionnodocente', 'categorianodoc'], 'integer'],
            [['documento'], 'string', 'max' => 8],
            [['documento'], 'string', 'min' => 7],
            [['legajo'], 'string', 'max' => 8],
            [['apellido', 'nombre'], 'string', 'max' => 70],
            [['area'], 'string', 'max' => 200],
            [['mail'], 'string', 'max' => 150],
            [['fechanac'], 'safe'],
            [['cuil'], 'string', 'max' => 13],
            [['cuil'], 'string', 'min' => 13],
            [['domicilio'], 'string', 'max' => 400],
            [['telefono'], 'string', 'max' => 100],
            ['mail', 'email'],
            [['genero'], 'exist', 'skipOnError' => true, 'targetClass' => Genero::className(), 'targetAttribute' => ['genero' => 'id']],
            [['localidad'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['localidad' => 'id']],
            [['tipodocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Tipodocumento::className(), 'targetAttribute' => ['tipodocumento' => 'id']],
            [['documento'], 'unique'],
            [['legajo'], 'unique'],
            [['mail'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'legajo' => 'Legajo',
            'apellido' => 'Apellido',
            'nombre' => 'Nombre',
            'genero' => 'Genero',
            'documento' => 'N° Documento',
            'condicionnodocente' => 'Condición',
            'mail' => 'Mail',
            'area' => 'Área',
            'categorianodoc' => 'Categoría del cargo',
            'fechanac' => 'Fecha de nacimiento', 
            'tipodocumento' => 'Tipo de documento', 
            'localidad' => 'Localidad', 
            'cuil' => 'CUIL', 
            'domicilio' => 'Domicilio', 
            'telefono' => 'Teléfono',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTareamantenimientos()
    {
        return $this->hasMany(Tareamantenimiento::className(), ['responsable' => 'id']);
    }

    public function getGenero0()
    {
        return $this->hasOne(Genero::className(), ['id' => 'genero']);
    }
    public function getCondicionnodocente0()
    {
        return $this->hasOne(Condicionnodocente::className(), ['id' => 'condicionnodocente']);
    }

    public function getDeclaracionjuradas()
    {
        return $this->hasMany(Declaracionjurada::className(), ['persona' => 'documento']);
    }
    public function getTipodocumento0() 
   { 
       return $this->hasOne(Tipodocumento::className(), ['id' => 'tipodocumento']); 
   } 

   public function getLocalidad0()
   {
       return $this->hasOne(Localidad::className(), ['id' => 'localidad']);
   }
}
