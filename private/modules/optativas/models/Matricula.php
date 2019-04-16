<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "matricula".
 *
 * @property int $id
 * @property string $fecha
 * @property int $alumno
 * @property int $comision
 * @property int $estadomatricula
 *
 * @property Calificacion[] $calificacions
 * @property Inasistencia[] $inasistencias
 * @property Comision $comision0
 * @property Alumno $alumno0
 * @property Estadomatricula $estadomatricula0
 * @property Seguimiento[] $seguimientos
 */
class Matricula extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    /**
     * {@inheritdoc}
     */

    public $aniolectivo;

    public static function tableName()
    {
        return 'matricula';
    }

    const SCENARIO_SEARCHINDEX = 'aniolectivo';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['fecha', 'alumno', 'comision', 'estadomatricula'];
        $scenarios[self::SCENARIO_SEARCHINDEX] = ['aniolectivo'];

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'alumno', 'comision', 'estadomatricula'], 'required'],
            [['aniolectivo'], 'required', 'message' => 'El Año lectivo es obligatorio',  'on' => self::SCENARIO_SEARCHINDEX],
            [['fecha'], 'safe'],
            [['alumno', 'comision', 'estadomatricula', 'division'], 'integer'],
            [['comision'], 'exist', 'skipOnError' => true, 'targetClass' => Comision::className(), 'targetAttribute' => ['comision' => 'id']],
            [['alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumno::className(), 'targetAttribute' => ['alumno' => 'id']],
            [['estadomatricula'], 'exist', 'skipOnError' => true, 'targetClass' => Estadomatricula::className(), 'targetAttribute' => ['estadomatricula' => 'id']],
            [['alumno', 'comision'], 'inscriptocicloycomision', 'on' => self::SCENARIO_CREATE],
            [['alumno', 'comision'], 'inscriptocicloyoptativa', 'on' => self::SCENARIO_CREATE]
        ];
    }

    public function inscriptocicloycomision($attribute, $params, $validator)
    {
        $matricula = Matricula::find()
        ->joinWith('comision0')
        ->where(['comision.id' => $this->comision])
        ->andWhere(['matricula.alumno' => $this->alumno])
        ->count();
        if ($matricula>0)
            $this->addError($attribute, 'El alumno seleccionado ya está inscripto en la comisión');
    }

    public function inscriptocicloyoptativa($attribute, $params, $validator)
    {
        $optativa = Comision::find()
        ->where(['id' => $this->comision])
        ->one()->optativa;

        $comisionotra = Optativa::find()
                            ->joinWith(['comisions','comisions.matriculas'])
                            ->where(['<>', 'comision.id', $this->comision])
                            ->andWhere(['matricula.alumno' => $this->alumno])
                            ->andWhere(['optativa.id' => $optativa])->count();
        if ($comisionotra>0)
            $this->addError($attribute, 'El alumno seleccionado ya está inscripto en otra comisión de esta Optativa');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'alumno' => 'Alumno',
            'comision' => 'Comision',
            'estadomatricula' => 'Estadomatricula',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacions()
    {
        return $this->hasMany(Calificacion::className(), ['matricula' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInasistencias()
    {
        return $this->hasMany(Inasistencia::className(), ['matricula' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComision0()
    {
        return $this->hasOne(Comision::className(), ['id' => 'comision']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno0()
    {
        return $this->hasOne(Alumno::className(), ['id' => 'alumno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadomatricula0()
    {
        return $this->hasOne(Estadomatricula::className(), ['id' => 'estadomatricula']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeguimientos()
    {
        return $this->hasMany(Seguimiento::className(), ['matricula' => 'id']);
    }

    public function getDivision0()
    {
        return $this->hasOne(Division::className(), ['id' => 'division']);
    }
}
