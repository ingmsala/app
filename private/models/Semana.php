<?php

namespace app\models;

use app\modules\curriculares\models\Aniolectivo;
use app\modules\horariogenerico\models\Horariogeneric;
use Yii;

/**
 * This is the model class for table "semana".
 *
 * @property int $id
 * @property int $aniolectivo
 * @property string $inicio
 * @property string $fin
 * @property int $publicada
 *
 * @property Clasevirtual[] $clasevirtuals
 * @property Aniolectivo $aniolectivo0
 */
class Semana extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'semana';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aniolectivo', 'inicio', 'fin', 'publicada'], 'required'],
            [['aniolectivo', 'publicada', 'tiposemana'], 'integer'],
            [['inicio', 'fin'], 'safe'],
            [['aniolectivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aniolectivo::className(), 'targetAttribute' => ['aniolectivo' => 'id']],
            [['tiposemana'], 'exist', 'skipOnError' => true, 'targetClass' => Tiposemana::className(), 'targetAttribute' => ['tiposemana' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aniolectivo' => 'Aniolectivo',
            'inicio' => 'Inicio',
            'fin' => 'Fin',
            'publicada' => 'Publicada',
            'tiposemana' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHorariogenerics()
    {
        return $this->hasMany(Horariogeneric::className(), ['semana' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAniolectivo0()
    {
        return $this->hasOne(Aniolectivo::className(), ['id' => 'aniolectivo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposemana0()
    {
        return $this->hasOne(Tiposemana::className(), ['id' => 'tiposemana']);
    }

    public function getFechas()
    {
        $model = $this;
        $start = $model->inicio;
        $end = $model->fin;

        $fechas = [];

        $dias2 = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado","Domingo"];

        if (is_string($start) === true) $start = strtotime($start);
        if (is_string($end) === true ) $end = strtotime($end);
        do {
            $fechas[date('w', $start)+1] = date('Y-m-d', $start);
            $start = strtotime("+ 1 day", $start);


        } while($start <= $end);

        return $fechas;

    }
}
