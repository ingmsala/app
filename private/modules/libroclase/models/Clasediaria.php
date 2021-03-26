<?php

namespace app\modules\libroclase\models;

use app\models\Catedra;
use app\models\Agente;
use app\modules\curriculares\models\Aniolectivo;
use Yii;

/**
 * This is the model class for table "clasediaria".
 *
 * @property int $id
 * @property int $catedra
 * @property int $temaunidad
 * @property string $fecha
 * @property string $fechacarga
 * @property int $agente
 * @property string $observaciones
 * @property int $modalidadclase
 *
 * @property Catedra $catedra0
 * @property Agente $agente0
 * @property Temaunidad $temaunidad0
 * @property Modalidadclase $modalidadclase0
 
 */
class Clasediaria extends \yii\db\ActiveRecord
{
    public $unidades;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clasediaria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catedra', 'fecha', 'fechacarga', 'aniolectivo', 'modalidadclase', 'tipocurricula'], 'required'],
            //[['observaciones'], 'required', 'on' => self::SCENARIO_EXTRACURRICULAR],
            ['observaciones', 'required', 'when' => function ($model) {
                return $model->tipocurricula > 1;
            }, 'whenClient' => "function (attribute, value) {
                return $('#clasediaria-tipocurricula').val() > 1;
            }"],
            [['catedra', 'agente', 'modalidadclase', 'tipocurricula'], 'integer'],
            [['fecha', 'fechacarga'], 'safe'],
            [['observaciones'], 'string'],
            [['catedra'], 'exist', 'skipOnError' => true, 'targetClass' => Catedra::className(), 'targetAttribute' => ['catedra' => 'id']],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['modalidadclase'], 'exist', 'skipOnError' => true, 'targetClass' => Modalidadclase::className(), 'targetAttribute' => ['modalidadclase' => 'id']],
            [['aniolectivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aniolectivo::className(), 'targetAttribute' => ['aniolectivo' => 'id']], 
            [['tipocurricula'], 'exist', 'skipOnError' => true, 'targetClass' => Tipocurricula::className(), 'targetAttribute' => ['tipocurricula' => 'id']], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catedra' => 'Cátedra',
            'fecha' => 'Fecha',
            'fechacarga' => 'Fecha de carga',
            'agente' => 'Agente',
            'observaciones' => 'Observaciones',
            'modalidadclase' => 'Modalidad de clase',
            'tipocurricula' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatedra0()
    {
        return $this->hasOne(Catedra::className(), ['id' => 'catedra']);
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
    public function getTemaxclases()
    {
        return $this->hasMany(Temaxclase::className(), ['clasediaria' => 'id']);
    }

    public function getHoraxclases()
    {
        return $this->hasMany(Horaxclase::className(), ['clasediaria' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModalidadclase0()
    {
        return $this->hasOne(Modalidadclase::className(), ['id' => 'modalidadclase']);
    }

    
    /**
    * @return \yii\db\ActiveQuery
    */
   public function getAniolectivo0() 
   { 
       return $this->hasOne(Aniolectivo::className(), ['id' => 'aniolectivo']); 
   } 

   public function getTipocurricula0() 
   { 
       return $this->hasOne(Tipocurricula::className(), ['id' => 'tipocurricula']); 
   } 
}
