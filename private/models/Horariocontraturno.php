<?php

namespace app\models;

use Yii;
use app\modules\curriculares\models\Aniolectivo;


/**
 * This is the model class for table "horariocontraturno".
 *
 * @property int $id
 * @property int $catedra
 * @property string $inicio
 * @property string $fin
 * @property int $diasemana
 * @property int $aniolectivo
 *
 * @property Aniolectivo $aniolectivo0
 * @property Catedra $catedra0
 * @property Diasemana $diasemana0
 */
class Horariocontraturno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horariocontraturno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catedra', 'agente', 'inicio', 'fin', 'diasemana'], 'required'],
            [['catedra', 'diasemana', 'aniolectivo'], 'integer'],
            [['inicio', 'fin'], 'safe'],
            [['aniolectivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aniolectivo::className(), 'targetAttribute' => ['aniolectivo' => 'id']],
            [['catedra'], 'exist', 'skipOnError' => true, 'targetClass' => Catedra::className(), 'targetAttribute' => ['catedra' => 'id']],
            [['diasemana'], 'exist', 'skipOnError' => true, 'targetClass' => Diasemana::className(), 'targetAttribute' => ['diasemana' => 'id']],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catedra' => 'Catedra',
            'inicio' => 'Inicio',
            'fin' => 'Fin',
            'diasemana' => 'Diasemana',
            'aniolectivo' => 'Aniolectivo',
            'agente' => 'Docente',
        ];
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
    public function getCatedra0()
    {
        return $this->hasOne(Catedra::className(), ['id' => 'catedra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiasemana0()
    {
        return $this->hasOne(Diasemana::className(), ['id' => 'diasemana']);
    }

    public function getAgente0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'agente']);
    }
}
