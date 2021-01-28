<?php

namespace app\modules\edh\models;

use app\models\Agente;
use app\modules\curriculares\models\Aniolectivo;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "caso".
 *
 * @property int $id
 * @property string $inicio
 * @property string $fin
 * @property string $resolucion
 * @property int $matricula
 * @property int $condicionfinal
 * @property int $estadocaso
 *
 * @property Condicionfinal $condicionfinal0
 * @property Estadocaso $estadocaso0
 * @property Matriculaedh $matricula0
 * @property Informeprofesional[] $informeprofesionals
 * @property Solicitudedh[] $solicitudedhs
 */
class Caso extends \yii\db\ActiveRecord
{
    public $aniolectivo;
    public $alumno;

    const SCENARIO_SEARCHINDEX = 'index';
    const SCENARIO_ABM = 'abm';
    const SCENARIO_CERRAR = 'cerrar';
    const SCENARIO_REFERENTE = 'ref';
    const SCENARIO_PRECEPTOR = 'prec';
    const SCENARIO_JEFE = 'jefe';
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCHINDEX] = ['aniolectivo', 'alumno', 'resolucion', 'estadocaso', 'referente', 'preceptor', 'jefe'];
        $scenarios[self::SCENARIO_ABM] = ['inicio', 'fin', 'matricula', 'resolucion', 'condicionfinal', 'estadocaso', 'referente', 'preceptor', 'jefe'];
        $scenarios[self::SCENARIO_CERRAR] = ['inicio', 'fin', 'matricula', 'resolucion', 'condicionfinal', 'estadocaso', 'referente', 'preceptor', 'jefe'];
        $scenarios[self::SCENARIO_REFERENTE] = ['referente'];
        $scenarios[self::SCENARIO_PRECEPTOR] = ['preceptor'];
        $scenarios[self::SCENARIO_JEFE] = ['jefe'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'caso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inicio', 'matricula', 'condicionfinal', 'estadocaso'], 'required', 'on' => self::SCENARIO_ABM],
            [['fin', 'condicionfinal'], 'required', 'on' => self::SCENARIO_CERRAR],
            [['referente'], 'required', 'on' => self::SCENARIO_REFERENTE],
            [['preceptor'], 'required', 'on' => self::SCENARIO_PRECEPTOR],
            [['jefe'], 'required', 'on' => self::SCENARIO_JEFE],
            [['inicio', 'fin'], 'safe'],
            [['matricula', 'condicionfinal', 'estadocaso', 'referente', 'preceptor', 'jefe'], 'integer'],
            [['resolucion'], 'string', 'max' => 150],
            [['condicionfinal'], 'exist', 'skipOnError' => true, 'targetClass' => Condicionfinal::className(), 'targetAttribute' => ['condicionfinal' => 'id']],
            [['estadocaso'], 'exist', 'skipOnError' => true, 'targetClass' => Estadocaso::className(), 'targetAttribute' => ['estadocaso' => 'id']],
            [['matricula'], 'exist', 'skipOnError' => true, 'targetClass' => Matriculaedh::className(), 'targetAttribute' => ['matricula' => 'id']],
            [['referente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['referente' => 'id']],
            [['preceptor'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['preceptor' => 'id']],
            [['jefe'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['jefe' => 'id']],
            [['inicio', 'fin'], 'inifin', 'on' => self::SCENARIO_ABM, 'skipOnEmpty' => false],
            [['inicio', 'fin'], 'inifin', 'on' => self::SCENARIO_CERRAR, 'skipOnEmpty' => false],
        ];
    }

    public function inifin($attribute, $params, $validator)
    {
        if($this->fin != null){
            if ($this->fin < $this->inicio)
                $this->addError($attribute, 'La fecha de cierre del caso no puede ser menos a la de solicitud');
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inicio' => 'Fecha de solicitud',
            'fin' => 'Fecha de cierre',
            'resolucion' => 'N° Resolución',
            'matricula' => 'Estudiante',
            'condicionfinal' => 'Condición estudiante',
            'estadocaso' => 'Estado del caso',
            'aniolectivo' => 'Año lectivo',
            'alumno' => 'Estudiante',
            'referente' => 'Referente del Equipo de Salud',
            'preceptor' => 'Preceptor/a',
            'jefe' => 'Jefe/a de piso',
        ];
    }
    
    public function getVencido(){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $max = date('Y-m-d');
        $ven = true;
        $cer = false;
        $confecha = false;
        $maxday = -2;
        

        if($this->estadocaso == 1){
            foreach ($this->solicitudedhs as $solicitud) {
                foreach ($solicitud->certificacionedhs as $certificado) {
                    $cer = true;
                    if($certificado->vencimiento == null){
                        continue;
                    }else{
                        $confecha = true;
                    }
                    
                    $difparamax = date_diff(date_create($max), date_create($certificado->vencimiento));
                    if($difparamax->days>=$maxday){
                        $max = $certificado->vencimiento;
                        $ven = false;
                        $maxday = $difparamax->days;
                    
                        
                    }
                }
            }
            
        }else{
            $ven = false; 
        }
        return [$ven, $maxday, $cer];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCondicionfinal0()
    {
        return $this->hasOne(Condicionfinal::className(), ['id' => 'condicionfinal']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadocaso0()
    {
        return $this->hasOne(Estadocaso::className(), ['id' => 'estadocaso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatricula0()
    {
        return $this->hasOne(Matriculaedh::className(), ['id' => 'matricula']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferente0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'referente']);
    }
    public function getPreceptor0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'preceptor']);
    }
    public function getJefe0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'jefe']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformeprofesionals()
    {
        return $this->hasMany(Informeprofesional::className(), ['caso' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudedhs()
    {
        return $this->hasMany(Solicitudedh::className(), ['caso' => 'id']);
    }

    public function getAniolectivo0()
    {

        return $this->hasOne(Aniolectivo::className(), ['id' => 'aniolectivo'])->via('matricula0');
    }

    public function getPlancursados()
    {
        return $this->hasMany(Plancursado::className(), ['caso' => 'id']);
    }

}
