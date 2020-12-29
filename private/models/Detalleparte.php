<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalleparte".
 *
 * @property int $id
 * @property int $parte
 * @property int $division
 * @property int $docente
 * @property int $hora
 * @property int $llego
 * @property int $retiro
 * @property int $falta
 * @property int $detalleadelrecup
 * @property int $estadoinasistencia
 *
 * @property Parte $parte0
 * @property Falta $falta0
 * @property Agente $agente0
 * @property Division $division0
 * @property Estadoinasistencia $estadoinasistencia0
 */
class Detalleparte extends \yii\db\ActiveRecord
{

    const SCENARIO_CONTROLREGENCIA = 'index';
    const SCENARIO_ABM = 'abm';

    public $anio;
    public $mes;
    public $solodia;
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ABM] = ['parte', 'division', 'agente', 'hora', 'falta', 'llego','retiro', 'detalleadelrecup'];
        $scenarios[self::SCENARIO_CONTROLREGENCIA] = ['anio', 'mes', 'agente', 'estadoinasistencia', 'solodia'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalleparte';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['parte', 'division', 'hora', 'falta'], 'required', 'on'=>self::SCENARIO_ABM],
            [['anio'], 'required', 'message' => 'Debe seleccionar un año lectivo', 'on'=>self::SCENARIO_CONTROLREGENCIA],
            [['parte', 'division', 'agente', 'llego', 'retiro', 'falta', 'estadoinasistencia'], 'integer'],
            
            [['parte'], 'exist', 'skipOnError' => true, 'targetClass' => Parte::className(), 'targetAttribute' => ['parte' => 'id']],
            [['falta'], 'exist', 'skipOnError' => true, 'targetClass' => Falta::className(), 'targetAttribute' => ['falta' => 'id']],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division' => 'id']],
            [['estadoinasistencia'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoinasistencia::className(), 'targetAttribute' => ['estadoinasistencia' => 'id']],
            ['agente', 'isVacante', 'on' => self::SCENARIO_ABM],
        ];
    }

    public function isVacante($attribute, $params, $validator)
    {
        
            if($this->agente == null && $this->falta != 5)
                $this->addError($attribute, 'Debe seleccionar un docente o marcar la opción hora vacante');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parte' => 'Parte',
            'division' => 'Division',
            'agente' => 'Agente',
            'hora' => 'Hora',
            'llego' => 'Llego',
            'retiro' => 'Retiro',
            'falta' => 'Tipo de Falta',
            'detalleadelrecup' => 'Detalle recupera/adelanto',
            'estadoinasistencia' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParte0()
    {
        return $this->hasOne(Parte::className(), ['id' => 'parte']);
    }

       /**
    * @return \yii\db\ActiveQuery
    */
   
   public function getFalta0()
   {
       return $this->hasOne(Falta::className(), ['id' => 'falta']);
   }

   public function getEstadoinasistencia0()
   {
       return $this->hasOne(Estadoinasistencia::className(), ['id' => 'estadoinasistencia']);
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
    public function getHora0()
    {
        return $this->hasOne(Hora::className(), ['id' => 'hora']);
    }

    public function getEstadoinasistenciaxpartes()
    {
        return $this->hasMany(Estadoinasistenciaxparte::className(), ['detalleparte' => 'id']);
    }

    public function getEstadoinasistencias()
    {
        return $this->hasMany(Estadoinasistencia::className(), ['id' => 'detalleparte'])->via('estadoinasistenciaxpartes');
    }
}
