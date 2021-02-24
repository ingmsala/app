<?php

namespace app\models;

use app\modules\solicitudprevios\models\Detallesolicitudext;
use app\modules\solicitudprevios\models\Solicitudinscripext;
use Yii;

/**
 * This is the model class for table "mesaexamen".
 *
 * @property int $id
 * @property int $nombre
 * @property string $fecha
 * @property string $hora
 * @property int $turnoexamen
 * @property int $espacio
 *
 * @property Turnoexamen $turnoexamen0
 * @property Espacio $espacio0
 * @property Tribunal[] $tribunals
 */
class Mesaexamen extends \yii\db\ActiveRecord
{
    const SCENARIO_AMB = 'abm';
    const SCENARIO_PASOS = 'pasos';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mesaexamen';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_AMB] = ['turnoexamen', 'espacio', 'fecha', 'hora', 'nombre', 'turnohorario'];
        $scenarios[self::SCENARIO_PASOS] = ['turnoexamen', 'espacio', 'fecha', 'hora', 'nombre', 'turnohorario'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['turnoexamen', 'espacio', 'turnohorario'], 'integer'],
            [['fecha', 'hora', 'turnoexamen', 'turnohorario'], 'required', 'on' => self::SCENARIO_AMB],
            [['turnoexamen'], 'required', 'on' => self::SCENARIO_PASOS],
            [['nombre', 'fecha', 'hora'], 'safe'],
            [['turnoexamen'], 'exist', 'skipOnError' => true, 'targetClass' => Turnoexamen::className(), 'targetAttribute' => ['turnoexamen' => 'id']],
            [['espacio'], 'exist', 'skipOnError' => true, 'targetClass' => Espacio::className(), 'targetAttribute' => ['espacio' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'turnoexamen' => 'Turno de examen',
            'espacio' => 'Espacio',
            'turnohorario' => 'Turno',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurnoexamen0()
    {
        return $this->hasOne(Turnoexamen::className(), ['id' => 'turnoexamen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspacio0()
    {
        return $this->hasOne(Espacio::className(), ['id' => 'espacio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTribunals()
    {
        return $this->hasMany(Tribunal::className(), ['mesaexamen' => 'id']);
    }

    public function getActividadxmesas()
    {
        return $this->hasMany(Actividadxmesa::className(), ['mesaexamen' => 'id']);
    }

    public function getActividads()
    {
        return $this->hasMany(Actividad::className(), ['id' => 'actividad'])->via('actividadxmesas');
    }

    public function getRepetidos()
    {
        $mesamismodia = [];
        //if($this->fecha != null || $this->hora !=null)
        $mesamismodia = Mesaexamen::find()
            ->where(['turnoexamen' => $this->turnoexamen])
            ->andWhere(['<>', 'id', $this->id])
            ->andWhere(['fecha' => $this->fecha])
            ->andWhere(['turnohorario' => $this->turnohorario])
            ->all();

        $actividades = $this->actividads;

        $solicitantes = Solicitudinscripext::find()
                //->select('detallesolicitudext.id, solicitudinscripext.apellido, solicitudinscripext.nombre, actividad.nombre as mail')
                ->joinWith(['detallesolicitudexts', 'detallesolicitudexts.actividad0'])
                ->where(['solicitudinscripext.turno' => $this->turnoexamen])
                ->andWhere(['in', 'actividad.id', array_column($actividades, 'id')])
                ->all();
        if($solicitantes == null)
            return 'Sin inscripciones';
        $repe = [];

        foreach ($solicitantes as $solicitud) {
            
            foreach ($solicitud->detallesolicitudexts as $detalle) {
                $mesamismodia = Mesaexamen::find()
                    ->joinWith(['actividadxmesas'])
                    ->where(['mesaexamen.turnoexamen' => $this->turnoexamen])
                    ->andWhere(['<>', 'mesaexamen.id', $this->id])
                    ->andWhere(['mesaexamen.fecha' => $this->fecha])
                    ->andWhere(['mesaexamen.turnohorario' => $this->turnohorario])
                    ->andWhere(['actividadxmesa.actividad' => $detalle->actividad])
                    ->all();
                    if($mesamismodia !=null){
                        $repe[$detalle->id] = $mesamismodia;
                    }
                   
            }
        
        }
        

        $alumnoinscripto = Detallesolicitudext::find()
                        ->joinWith(['solicitud0', 'actividad0'])
                        ->where(['solicitudinscripext.turno' => $this->turnoexamen])
                        ->andWhere(['in', 'actividad.id', array_column($actividades, 'id')])
                        ->all();

        
        return $repe;
    }

    public function getRepetidosinternos()
    {
        $actividades = $this->actividads;
        $repe = [];
        foreach ($actividades as $actividad) {
            $alumnoinscripto = Detallesolicitudext::find()
                ->joinWith(['solicitud0', 'actividad0'])
                ->where(['solicitudinscripext.turno' => $this->turnoexamen])
                ->andWhere(['actividad.id' => $actividad])
                ->all();

            $otrasmismamesa = Detallesolicitudext::find()
                ->joinWith(['solicitud0', 'actividad0'])
                ->where(['solicitudinscripext.turno' => $this->turnoexamen])
                ->andWhere(['in', 'actividad.id', array_column($actividades, 'id')])
                ->andWhere(['<>', 'actividad.id', $actividad->id])
                ->andWhere(['in', 'solicitudinscripext.documento', array_column(array_column($alumnoinscripto, 'solicitud0'),'documento')])
                ->all();
            
            foreach ($alumnoinscripto as $detotras) {
                $repe[$detotras->id] = $otrasmismamesa;
            }

        }
        return $repe;
        
    }
}
