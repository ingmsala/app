<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "docente".
 *
 * @property int $id
 * @property string $legajo
 * @property string $apellido
 * @property string $nombre
 * @property string $mail
 * @property string $fechanac
 * @property int $genero
 * @property string $documento
 *
 * @property Detallecatedra[] $detallecatedras
 * @property Genero $genero0
 * @property Nombramiento[] $nombramientos
 */
class Docente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const SCENARIO_FINDHORARIOLOGIN = 'logindoc';
    const SCENARIO_ABM = 'abmdoc';
    const SCENARIO_DECLARACIONJURADA = 'declaracionjurada';
    const SCENARIO_FONID = 'fonid';
   

    

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_FINDHORARIOLOGIN] = ['legajo'];
        $scenarios[self::SCENARIO_ABM] = ['apellido', 'nombre', 'legajo', 'genero', 'documento', 'tipodocumento', 'mail', 'fechanac', 'mapuche'];
        $scenarios[self::SCENARIO_DECLARACIONJURADA] = ['apellido', 'nombre', 'legajo', 'documento', 'tipodocumento', 'mail', 'telefono', 'fechanac', 'cuil', 'domicilio', 'localidad', 'mapuche'];
        $scenarios[self::SCENARIO_FONID] = ['apellido', 'nombre', 'legajo', 'cuil'];
        
        return $scenarios;
    }

    public static function tableName()
    {
        return 'docente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido', 'nombre', 'genero','documento','tipodocumento', 'mail'], 'required', 'on' => self::SCENARIO_ABM],
            [['apellido', 'nombre', 'legajo', 'cuil'], 'required', 'on' => self::SCENARIO_FONID],
            [['apellido', 'nombre', 'legajo', 'documento', 'tipodocumento', 'mail', 'telefono', 'fechanac', 'cuil', 'domicilio', 'localidad'], 'required', 'on' => self::SCENARIO_DECLARACIONJURADA],
            [['legajo'], 'required',  'on' => self::SCENARIO_FINDHORARIOLOGIN],
            [['genero'], 'integer'],
            [['mapuche'], 'integer'],
            [['documento'], 'string', 'max' => 8],
            [['documento'], 'string', 'min' => 7],
            [['legajo'], 'string', 'max' => 8],
            [['apellido', 'nombre'], 'string', 'max' => 70],
            [['mail'], 'string', 'max' => 200],
            [['fechanac'], 'safe'],
            [['cuil'], 'string', 'max' => 13],
            [['cuil'], 'string', 'min' => 13],
            [['domicilio'], 'string', 'max' => 400],
            [['telefono'], 'string', 'max' => 100],
            [['legajo'], 'unique', 'on' => self::SCENARIO_ABM],
            [['documento'], 'unique'],
            [['mail'], 'unique'],
            ['mail', 'email'],
            [['genero'], 'exist', 'skipOnError' => true, 'targetClass' => Genero::className(), 'targetAttribute' => ['genero' => 'id']],
            [['localidad'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['localidad' => 'id']],
            [['tipodocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Tipodocumento::className(), 'targetAttribute' => ['tipodocumento' => 'id']],
            [['legajo'], 'findDoc', 'on' => self::SCENARIO_FINDHORARIOLOGIN],
        ];
    }

    public function findDoc($attribute, $params, $validator)
    {
        $doc = Docente::find()
            ->joinWith('detallecatedras')
            ->where(['=', 'detallecatedra.revista', 6])
            ->andWhere(['legajo' => $this->legajo])->all();
        if (count($doc)<1)
            $this->addError($attribute, 'El legajo no corresponde a un docente con un horario activo. Pruebe con su DNI. De persistir el inconveniente consulte en regencia');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'legajo' => 'Legajo',
            'apellido' => 'Apellidos',
            'nombre' => 'Nombres',
            'genero' => 'Género',
            'documento' => 'Documento',
            'mail' => 'Mail', 
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
    public function getDetallecatedras()
    {
        return $this->hasMany(Detallecatedra::className(), ['docente' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenero0()
    {
        return $this->hasOne(Genero::className(), ['id' => 'genero']);
    }

    public function getCatedras()
    {
        return $this->hasMany(Catedra::className(), ['id' => 'catedra'])->via('detallecatedras');
    }

    public function getCondicions()
    {
        return $this->hasMany(Condicion::className(), ['id' => 'condicion'])->via('detallecatedras');
    }

    public function getNombramientos()
    {
        return $this->hasMany(Nombramiento::className(), ['docente' => 'id']);
    }

    public function getDetallepartes()
    {
        return $this->hasMany(Detalleparte::className(), ['docente' => 'id']);
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
