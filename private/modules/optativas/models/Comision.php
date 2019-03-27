<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "comision".
 *
 * @property int $id
 * @property string $nombre
 * @property int $optativa
 * @property int $cupo
 *
 * @property Clase[] $clases
 * @property Optativa $optativa0
 * @property Docentexcomision[] $docentexcomisions
 * @property Matricula[] $matriculas
 */
class Comision extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comision';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'optativa'], 'required'],
            [['optativa', 'cupo'], 'integer'],
            [['nombre'], 'string', 'max' => 20],
            [['optativa'], 'exist', 'skipOnError' => true, 'targetClass' => Optativa::className(), 'targetAttribute' => ['optativa' => 'id']],
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
            'optativa' => 'Optativa',
            'cupo' => 'Cupo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClases()
    {
        return $this->hasMany(Clase::className(), ['comision' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptativa0()
    {
        return $this->hasOne(Optativa::className(), ['id' => 'optativa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocentexcomisions()
    {
        return $this->hasMany(Docentexcomision::className(), ['comision' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatriculas()
    {
        return $this->hasMany(Matricula::className(), ['comision' => 'id']);
    }
}
