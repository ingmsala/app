<?php

namespace app\models;

use app\modules\curriculares\models\Aniolectivo;
use Yii;

/**
 * This is the model class for table "horario".
 *
 * @property int $id
 * @property int $catedra
 * @property int $hora
 * @property int $diasemana
 * @property int $tipo
 * @property int $tipomovilidad
 *
 * @property Diasemana $diasemana0
 * @property Hora $hora0
 * @property Tipoparte $tipo0
 * @property Catedra $catedra0
 * @property Tipomovilidad $tipomovilidad0
 */
class Horario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const SCENARIO_CREATEHORARIO = 'createdesdehorario';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATEHORARIO] = ['catedra', 'hora', 'diasemana', 'tipo', 'aniolectivo'];
        return $scenarios;
    }

    public static function tableName()
    {
        return 'horario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catedra', 'hora', 'diasemana', 'tipo', 'tipomovilidad'], 'required'],
            [['catedra', 'hora', 'diasemana', 'tipo', 'tipomovilidad', 'aniolectivo'], 'integer'],
            
            
            [['diasemana'], 'exist', 'skipOnError' => true, 'targetClass' => Diasemana::className(), 'targetAttribute' => ['diasemana' => 'id']],
            [['hora'], 'exist', 'skipOnError' => true, 'targetClass' => Hora::className(), 'targetAttribute' => ['hora' => 'id']],
            [['tipo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoparte::className(), 'targetAttribute' => ['tipo' => 'id']],
            [['catedra'], 'exist', 'skipOnError' => true, 'targetClass' => Catedra::className(), 'targetAttribute' => ['catedra' => 'id']],
            [['tipomovilidad'], 'exist', 'skipOnError' => true, 'targetClass' => Tipomovilidad::className(), 'targetAttribute' => ['tipomovilidad' => 'id']],
            [['aniolectivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aniolectivo::className(), 'targetAttribute' => ['aniolectivo' => 'id']],
            ['tipo', 'yaExiste', 'on' => self::SCENARIO_CREATEHORARIO],
        ];
    }

    public function yaExiste($attribute, $params, $validator)
    {
        $horarios = Horario::find()
            ->joinWith(['catedra0'])
            ->where(['diasemana' => $this->diasemana])
            ->andWhere(['catedra.division' => $this->catedra0->division])
            ->andWhere(['tipo' => $this->tipo])
            ->andWhere(['hora' => $this->hora])
            ->andWhere(['aniolectivo' => $this->aniolectivo])
            ->all();
        //return var_dump(count($horarios)); 

        if (count($horarios)>0){
           
            $this->addError($attribute, 'Hora ya asignada: '.$horarios[0]->catedra0->actividad0->nombre);
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
            'diasemana' => 'Diasemana',
            'tipo' => 'Tipo',
            'tipomovilidad' => 'Movilidad',
            'aniolectivo' => 'Año lectivo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiasemana0()
    {
        return $this->hasOne(Diasemana::className(), ['id' => 'diasemana']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHora0()
    {
        return $this->hasOne(Hora::className(), ['id' => 'hora']);
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
    public function getCatedra0()
    {
        return $this->hasOne(Catedra::className(), ['id' => 'catedra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipomovilidad0()
    {
        return $this->hasOne(Tipomovilidad::className(), ['id' => 'tipomovilidad']);
    }

    public function getAniolectivo0()
    {
        return $this->hasOne(Aniolectivo::className(), ['id' => 'aniolectivo']);
    }
}
