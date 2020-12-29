<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nombramiento".
 *
 * @property int $id
 * @property string $nombre
 * @property int $cargo
 * @property int $horas
 * @property int $agente
 * @property int $revista
 * @property int $condicion
 * @property int $division
 * @property int $suplente
 * @property int $extension 
 * @property int $resolucion 
 * @property int $fechaInicio 
 * @property int $fechaFin 
 * @property int $resolucionext 
 * @property int $fechaInicioext
 * @property int $fechaFinext
 * @property Condicion $condicion0
 * @property Extension $extension0 
 * @property Cargo $cargo0
 * @property Agente $agente0
 * @property Division $division0
 * @property Revista $revista0
 * @property Nombramiento $suplente0
 * @property Nombramiento[] $nombramientos
 * @property int $activo
 */
class Nombramiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nombramiento';
    }

    var $cantidad;

 const SCENARIO_ABMDIVISION = 'abmdivision';
 const SCENARIO_ABMNOMBRAMIENTO = 'abm';

    

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ABMNOMBRAMIENTO] = ['nombre', 'cargo', 'horas', 'agente', 'revista', 'condicion', 'extension', 'suplente', 'fechaInicio', 'agente', 'division',  'fechaFin', 'resolucion', 'fechaInicioext', 'fechaFinext', 'resolucionext', 'activo'];
        $scenarios[self::SCENARIO_ABMDIVISION] = ['division'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cargo', 'horas', 'agente', 'revista', 'condicion'], 'required', 'on'=>self::SCENARIO_ABMNOMBRAMIENTO],
            [['cargo', 'horas', 'agente', 'revista', 'condicion', 'division', 'suplente', 'extension', 'activo'], 'integer'],
            [['fechaInicio', 'fechaFin', 'resolucion', 'fechaInicioext', 'fechaFinext', 'resolucionext'], 'safe'],
            [['fechaInicio', 'fechaFin', 'fechaInicioext', 'fechaFinext'], 'default', 'value' => null],
            [['nombre'], 'string', 'max' => 150],
            [['extension'], 'exist', 'skipOnError' => true, 'targetClass' => Extension::className(), 'targetAttribute' => ['extension' => 'id']], 
            [['condicion'], 'exist', 'skipOnError' => true, 'targetClass' => Condicion::className(), 'targetAttribute' => ['condicion' => 'id']],
            [['cargo'], 'exist', 'skipOnError' => true, 'targetClass' => Cargo::className(), 'targetAttribute' => ['cargo' => 'id']],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division' => 'id']],
            [['revista'], 'exist', 'skipOnError' => true, 'targetClass' => Revista::className(), 'targetAttribute' => ['revista' => 'id']],
            [['suplente'], 'exist', 'skipOnError' => true, 'targetClass' => Nombramiento::className(), 'targetAttribute' => ['suplente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Función',
            'cargo' => 'Cargo',
            'horas' => 'Horas',
            'agente' => 'Agente',
            'revista' => 'Revista',
            'condicion' => 'Condicion',
            'division' => 'Division',
            'suplente' => 'Suplente',
            'extension' => 'Extensión', 
            'resolucion' => 'Resolución', 
            'fechaInicio' => 'Fecha de Inicio', 
            'fechaFin' => 'Fecha de Fin', 
            'resolucionext' => 'Resolución de extensión', 
            'fechaInicioext' => 'Fecha de Inicio de extensión', 
            'fechaFinext' => 'Fecha de Fin de extensión', 
            'activo' => 'Activo', 
        ];
    }

    /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getExtension0() 
   { 
       return $this->hasOne(Extension::className(), ['id' => 'extension']); 
   }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCondicion0()
    {
        return $this->hasOne(Condicion::className(), ['id' => 'condicion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargo0()
    {
        return $this->hasOne(Cargo::className(), ['id' => 'cargo']);
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
    public function getDivision0()
    {
        return $this->hasOne(Division::className(), ['id' => 'division']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRevista0()
    {
        return $this->hasOne(Revista::className(), ['id' => 'revista']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuplente0()
    {
        return $this->hasOne(Nombramiento::className(), ['id' => 'suplente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNombramientos()
    {
        return $this->hasMany(Nombramiento::className(), ['suplente' => 'id']);
    }

    public function getLabel()
    {
        return '('.$this->cargo.') '.$this->agente0->apellido.', '.$this->agente0->nombre;
    }

    public function getsuplente($id){
        $e = new Nombramiento();
        $e = Nombramiento::findOne($id);
        return $e;
    }

}
