<?php

namespace app\modules\libroclase\models;

use Yii;

/**
 * This is the model class for table "temaunidad".
 *
 * @property int $id
 * @property int $detalleunidad
 * @property double $horasesperadas
 * @property int $prioridad
 * @property string $descripcion
 *
 * @property Clasediaria[] $clasediarias
 * @property Detalleunidad $detalleunidad0
 */
class Temaunidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'temaunidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detalleunidad'], 'required'],
            [['detalleunidad', 'prioridad'], 'integer'],
            [['horasesperadas'], 'number'],
            [['descripcion'], 'string'],
            [['detalleunidad'], 'exist', 'skipOnError' => true, 'targetClass' => Detalleunidad::className(), 'targetAttribute' => ['detalleunidad' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'detalleunidad' => 'Detalle de unidad',
            'horasesperadas' => 'Horas esperadas',
            'prioridad' => 'Prioridad',
            'descripcion' => 'Descripción',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasediarias()
    {
        return $this->hasMany(Clasediaria::className(), ['temaunidad' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleunidad0()
    {
        return $this->hasOne(Detalleunidad::className(), ['id' => 'detalleunidad']);
    }
}
