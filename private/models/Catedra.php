<?php

namespace app\models;

use app\controllers\CatedraController;
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
    public $agente;
    public $condicion;
    public $actividadnom;
    public $divisionnom;
    public $resolucion;
    public $activo;
   

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCHINDEX] = ['propuesta', 'condicion', 'agente', 'actividadnom', 'division', 'resolucion', 'activo'];
        return $scenarios;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actividad', 'division'], 'required'],
            [['actividad', 'division'], 'integer'],
            [['division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division' => 'id']],
            [['actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::className(), 'targetAttribute' => ['actividad' => 'id']],
            //[['actividad', 'division'], 'unique', 'targetClass' => '\app\models\Catedra', 'targetAttribute' => ['actividad', 'division'], 'message' => 'Ya existe la Cátedra que desea crear.'],
            [['actividad', 'division'], 'catedraDuplicada'],
        ];
    }

    public function catedraDuplicada($attribute, $params, $validator)
    {
        $cat = Catedra::find()
        ->where(['actividad' => $this->actividad])
        ->andWhere(['division' => $this->division])->one();
        if ($cat!=null){
            $this->addError($attribute, 'Las contraseña anterior es incorrecta');
            //$catcon = new CatedraController();
            Yii::$app->session->setFlash('info', "Está seleccionando más de una materia de un año de cursada.");
            return Yii::$app->getResponse()->redirect(['catedra/view', 'id' => $cat->id]);
            //return $this->redirect(['view', 'id' => $cat->id]);
        }
            
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

    public function getHorarios()
    {
        return $this->hasMany(Horario::className(), ['catedra' => 'id']);
    }

    public function getAgentes()
    {
        return $this->hasMany(Agente::className(), ['id' => 'agente'])->via('detallecatedras');
    }

    public function getNameActividad($id)
    {
       $actividades = Actividad::find()->where(['id'=> $id])->all();
       foreach($actividades as $actividad) {
        return $actividad;
       }
    }

    public function docenteHorario($id, $al)
    {
       $detcatedras = Detallecatedra::find()
                        ->where(['catedra'=> $id])
                        ->andWhere(['aniolectivo' => $al])
                        ->andWhere(['revista' => 6])
                        ->one();
        //return var_dump($detcatedras);
        try {
            return $detcatedras->agente0->apellido.', '.$detcatedras->agente0->nombre; 
        } catch (\Throwable $th) {
            return '';
        }
        
       
    }




}
