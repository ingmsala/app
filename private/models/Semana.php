<?php

namespace app\models;

use app\modules\curriculares\models\Aniolectivo;


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
            [['aniolectivo', 'publicada'], 'integer'],
            [['inicio', 'fin'], 'safe'],
            [['aniolectivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aniolectivo::className(), 'targetAttribute' => ['aniolectivo' => 'id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasevirtuals()
    {
        return $this->hasMany(Clasevirtual::className(), ['semana' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAniolectivo0()
    {
        return $this->hasOne(Aniolectivo::className(), ['id' => 'aniolectivo']);
    }
}
