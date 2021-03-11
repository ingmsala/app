<?php

namespace app\modules\horariogenerico\models;

use app\models\Catedra;
use app\models\Diasemana;
use app\models\Semana;
use Yii;

/**
 * This is the model class for table "horariogeneric".
 *
 * @property int $id
 * @property int $catedra
 * @property int $horareloj
 * @property int $semana
 * @property string $fecha
 * @property int $burbuja
 * @property int $aniolectivo
 * @property int $diasemana
 *
 * @property Catedra $catedra0
 * @property Semana $semana0
 * @property Diasemana $diasemana0
 * @property Horareloj $horareloj0
 * @property Burbuja $burbuja0
 */
class Horariogeneric extends \yii\db\ActiveRecord
{
    public $division;
    public $burbujanombre;
    public $diasemananombre;
    public $cant;
    public $divid;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horariogeneric';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catedra', 'horareloj', 'semana', 'fecha', 'aniolectivo', 'diasemana'], 'required'],
            [['catedra', 'horareloj', 'semana', 'burbuja', 'aniolectivo', 'diasemana'], 'integer'],

            //[['catedra', 'horareloj', 'semana', 'fecha', 'aniolectivo', 'diasemana'], 'unique', 'targetAttribute' => ['catedra', 'horareloj', 'semana', 'fecha', 'aniolectivo', 'diasemana']],

            [['fecha'], 'safe'],
            [['catedra'], 'exist', 'skipOnError' => true, 'targetClass' => Catedra::className(), 'targetAttribute' => ['catedra' => 'id']],
            [['semana'], 'exist', 'skipOnError' => true, 'targetClass' => Semana::className(), 'targetAttribute' => ['semana' => 'id']],
            [['diasemana'], 'exist', 'skipOnError' => true, 'targetClass' => Diasemana::className(), 'targetAttribute' => ['diasemana' => 'id']],
            [['horareloj'], 'exist', 'skipOnError' => true, 'targetClass' => Horareloj::className(), 'targetAttribute' => ['horareloj' => 'id']],
            [['burbuja'], 'exist', 'skipOnError' => true, 'targetClass' => Burbuja::className(), 'targetAttribute' => ['burbuja' => 'id']],
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
            'horareloj' => 'Horareloj',
            'semana' => 'Semana',
            'fecha' => 'Fecha',
            'burbuja' => 'Burbuja',
            'aniolectivo' => 'Aniolectivo',
            'diasemana' => 'Diasemana',
            'division' => 'División',
            'burbujanombre' => 'Burbuja',
            'diasemananombre' => 'cantidad',
            'cant' => 'Día',
            'divid' => 'Día',
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
    public function getSemana0()
    {
        return $this->hasOne(Semana::className(), ['id' => 'semana']);
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
    public function getHorareloj0()
    {
        return $this->hasOne(Horareloj::className(), ['id' => 'horareloj']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBurbuja0()
    {
        return $this->hasOne(Burbuja::className(), ['id' => 'burbuja']);
    }
}
