<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "catedra".
 *
 * @property int $id
 * @property int $actividad
 * @property int $division
 *
 * @property Division $division0
 * @property Actividad $actividad0
 * @property Detallecatedra[] $detallecatedras
 */
class Catedra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catedra';
    }

    const SCENARIO_SEARCHINDEX = 'index';

    public $propuesta;
    public $docente;
    public $actividadnom;
    public $divisionnom;
    public $resolucion;
   

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCHINDEX] = ['propuesta', 'docente', 'actividadnom', 'division', 'resolucion'];
        return $scenarios;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actividad'], 'required'],
            [['actividad', 'division'], 'integer'],
            [['division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division' => 'id']],
            [['actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::className(), 'targetAttribute' => ['actividad' => 'id']],
            [['actividad', 'division'], 'unique', 'targetClass' => '\app\models\Catedra', 'targetAttribute' => ['actividad', 'division'], 'message' => 'Ya existe la Cátedra que desea crear.'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'actividad' => 'Actividad',
            'division' => 'Division',
        ];
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
    public function getActividad0()
    {
        return $this->hasOne(Actividad::className(), ['id' => 'actividad']);
    }

    public function getPropuesta0()
    {
        return $this->hasOne(Propuesta::className(), ['id' => 'propuesta'])->via('actividad0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallecatedras()
    {
        return $this->hasMany(Detallecatedra::className(), ['catedra' => 'id']);
    }

    public function getDocentes()
    {
        return $this->hasMany(Docente::className(), ['id' => 'docente'])->via('detallecatedras');
    }

    public function getNameActividad($id)
    {
       $actividades = Actividad::find()->where(['id'=> $id])->all();
       foreach($actividades as $actividad) {
        return $actividad;
       }
    }
/*
    public function getDocentes($id){
        $detallecatedras = DetalleCatedra::find()
            ->select('docente')
            ->where(['catedra' => $id])->all();
        $docentes = Docente::find()
            ->select('concat(apellido, ", ", nombre)')
            ->where('in', 'id', $detallecatedras);
        return $docentes;
    }*/

}
