<?php

namespace app\models;
use yii\web\NotFoundHttpException;


use Yii;

/**
 * This is the model class for table "horarioexamen".
 *
 * @property int $id
 * @property int $catedra
 * @property int $hora
 * @property int $tipo
 * @property int $anioxtrimestral
 * @property string $fecha
 * @property int $cambiada
 *
 * @property Catedra $catedra0
 * @property Anioxtrimestral $anioxtrimestral0
 * @property Tipoparte $tipo0
 * @property Hora $hora0
 */
class Horarioexamen extends \yii\db\ActiveRecord
{
    const SCENARIO_MIGRACIONHORARIO = 'migracionfechas';
    const SCENARIO_MIGRACIONHORARIO2 = 'migracionfechas2';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_MIGRACIONHORARIO] = ['catedra', 'hora', 'diasemana', 'tipo', 'cambiada'];
        $scenarios[self::SCENARIO_MIGRACIONHORARIO2] = ['catedra', 'hora', 'diasemana', 'tipo', 'cambiada'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horarioexamen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catedra', 'hora', 'tipo', 'anioxtrimestral', 'fecha'], 'required'],
            [['catedra', 'hora', 'tipo', 'anioxtrimestral', 'cambiada'], 'integer'],
            [['fecha'], 'safe'],
            [['catedra'], 'exist', 'skipOnError' => true, 'targetClass' => Catedra::className(), 'targetAttribute' => ['catedra' => 'id']],
            [['anioxtrimestral'], 'exist', 'skipOnError' => true, 'targetClass' => Anioxtrimestral::className(), 'targetAttribute' => ['anioxtrimestral' => 'id']],
            [['tipo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoparte::className(), 'targetAttribute' => ['tipo' => 'id']],
            [['hora'], 'exist', 'skipOnError' => true, 'targetClass' => Hora::className(), 'targetAttribute' => ['hora' => 'id']],
            ['tipo', 'yaExiste', 'on' => self::SCENARIO_MIGRACIONHORARIO],
        ];
    }

    public function yaExiste($attribute, $params, $validator)
    {
        $horarios = Horarioexamen::find()
            ->joinWith(['catedra0'])
            ->where(['fecha' => $this->fecha])
            ->andWhere(['catedra.division' => $this->catedra0->division])
            ->andWhere(['tipo' => $this->tipo])
            ->andWhere(['hora' => $this->hora])
            ->andWhere(['cambiada' => 2])
            ->all();
        //return var_dump(count($horarios)); 

        if (count($horarios)>0){
           
           $h = 10/0;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catedra' => 'Catedra',
            'hora' => 'Hora',
            'tipo' => 'Tipo',
            'anioxtrimestral' => 'Anioxtrimestral',
            'fecha' => 'Fecha',
            'cambiada' => 'Cambiada',
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
    public function getAnioxtrimestral0()
    {
        return $this->hasOne(Anioxtrimestral::className(), ['id' => 'anioxtrimestral']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo0()
    {
        return $this->hasOne(Tipoparte::className(), ['id' => 'tipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHora0()
    {
        return $this->hasOne(Hora::className(), ['id' => 'hora']);
    }
}
