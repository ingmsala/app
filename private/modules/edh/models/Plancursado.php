<?php

namespace app\modules\edh\models;

use app\models\Detallecatedra;
use Yii;

/**
 * This is the model class for table "plancursado".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $fecha
 * @property int $caso
 * @property int $tipoplan
 *
 * @property Catedradeplan[] $catedradeplans
 * @property Caso $caso0
 * @property Tipoplancursado $tipoplan0
 * @property Seguimientoplan[] $seguimientoplans
 */
class Plancursado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plancursado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'fecha', 'caso', 'tipoplan'], 'required'],
            [['descripcion'], 'string'],
            [['fecha'], 'safe'],
            [['caso', 'tipoplan'], 'integer'],
            [['caso'], 'exist', 'skipOnError' => true, 'targetClass' => Caso::className(), 'targetAttribute' => ['caso' => 'id']],
            [['tipoplan'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoplancursado::className(), 'targetAttribute' => ['tipoplan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'fecha' => 'Fecha',
            'caso' => 'Caso',
            'tipoplan' => 'Tipoplan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatedradeplans()
    {
        return $this->hasMany(Catedradeplan::className(), ['plan' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaso0()
    {
        return $this->hasOne(Caso::className(), ['id' => 'caso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoplan0()
    {
        return $this->hasOne(Tipoplancursado::className(), ['id' => 'tipoplan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeguimientoplans()
    {
        return $this->hasMany(Seguimientoplan::className(), ['plan' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleplancursados()
    {
        return $this->hasMany(Detalleplancursado::className(), ['plan' => 'id']);
    }


    public function nuevoPlanPrincipal($caso)
    {
        $model = new Plancursado();
        
        $caso = Caso::findOne($caso);

        $model->caso = $caso->id;
        $model->tipoplan = 1;
        $model->descripcion = 'El plan de cursado principal permite gestionar todas las materias en un plan integral, carga de notas y la realización de inferencias sobre el rendimiento';
        $model->fecha = date('Y-m-d');
        $model->save();

        $docentes_curso = Detallecatedra::find()
            ->joinWith(['catedra0', 'catedra0.actividad0', 'agente0'])
            ->where(['catedra.division' => $caso->matricula0->division])
            ->andWhere(['<>', 'actividad.id', 31])
            ->andWhere(['<>', 'actividad.id', 33])
            ->andWhere(['<>', 'actividad.id', 195])
            ->andWhere(['revista' => 6])
            ->andWhere(['aniolectivo' => $caso->matricula0->aniolectivo])
            ->orderBy('agente.apellido, agente.nombre')
            ->all();

        foreach ($docentes_curso as $detcat) {
            
            $detalleplancursadoX = new Detalleplancursado();
            $detalleplancursadoX->plan = $model->id;
            $detalleplancursadoX->descripcion = '(Editar)';
            $detalleplancursadoX->catedra = $detcat->catedra;
            $detalleplancursadoX->estadodetplan = 1;
            $detalleplancursadoX->save();
        }    

        $actuacion = new Actuacionedh();
        $actuacion = $actuacion->nuevaActuacion($model->caso, 4, 'Se crea un nuevo plan de cursado principal: #'.$model->id, 0);
        
        return $model;
    }
}
