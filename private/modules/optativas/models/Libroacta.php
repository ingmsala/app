<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "libroacta".
 *
 * @property int $id
 * @property string $nombre
 * @property int $estado
 * @property int $aniolectivo
 *
 * @property Acta[] $actas
 * @property Aniolectivo $aniolectivo0
 * @property Estadolibro $estadolibro0
 */
class Libroacta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libroacta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'estado', 'aniolectivo'], 'required'],
            [['estado', 'aniolectivo'], 'integer'],
            [['nombre'], 'string', 'max' => 10],
            [['aniolectivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aniolectivo::className(), 'targetAttribute' => ['aniolectivo' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadolibro::className(), 'targetAttribute' => ['estado' => 'id']], 
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
            'estado' => 'Estado',
            'aniolectivo' => 'Aniolectivo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActas()
    {
        return $this->hasMany(Acta::className(), ['libro' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAniolectivo0()
    {
        return $this->hasOne(Aniolectivo::className(), ['id' => 'aniolectivo']);
    }

    public function getEstadolibro0()
    {
        return $this->hasOne(Estadolibro::className(), ['id' => 'estado']);
    }
}
