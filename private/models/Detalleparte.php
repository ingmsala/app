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
 * @property int $estadoinasistencia
 *
 * @property Parte $parte0
 * @property Falta $falta0
 * @property Docente $docente0
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
        $scenarios[self::SCENARIO_ABM] = ['parte', 'division', 'docente', 'hora', 'falta', 'llego','retiro'];
        $scenarios[self::SCENARIO_CONTROLREGENCIA] = ['anio', 'mes', 'docente', 'estadoinasistencia', 'solodia'];
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
            
            [['parte', 'division', 'docente', 'hora', 'falta'], 'required', 'on'=>self::SCENARIO_ABM],
            [['anio'], 'required', 'message' => 'Debe seleccionar un año lectivo', 'on'=>self::SCENARIO_CONTROLREGENCIA],
            [['parte', 'division', 'docente', 'llego', 'retiro', 'falta', 'estadoinasistencia'], 'integer'],
            
            [['parte'], 'exist', 'skipOnError' => true, 'targetClass' => Parte::className(), 'targetAttribute' => ['parte' => 'id']],
            [['falta'], 'exist', 'skipOnError' => true, 'targetClass' => Falta::className(), 'targetAttribute' => ['falta' => 'id']],
            [['docente'], 'exist', 'skipOnError' => true, 'targetClass' => Docente::className(), 'targetAttribute' => ['docente' => 'id']],
            [['division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division' => 'id']],
            [['estadoinasistencia'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoinasistencia::className(), 'targetAttribute' => ['estadoinasistencia' => 'id']],
        ];
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
            'docente' => 'Docente',
            'hora' => 'Hora',
            'llego' => 'Llego',
            'retiro' => 'Retiro',
            'falta' => 'Tipo de Falta',
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
    public function getDocente0()
    {
        return $this->hasOne(Docente::className(), ['id' => 'docente']);
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
