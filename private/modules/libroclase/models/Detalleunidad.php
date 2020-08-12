<?php

namespace app\modules\libroclase\models;

use Yii;

/**
 * This is the model class for table "detalleunidad".
 *
 * @property int $id
 * @property string $nombre
 * @property int $unidad
 * @property int $programa
 *
 * @property Programa $programa0
 * @property Unidad $unidad0
 * @property Temaunidad[] $temaunidads
 */
class Detalleunidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalleunidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unidad'], 'required'],
            [['unidad', 'programa'], 'integer'],
            [['nombre'], 'string', 'max' => 300],
            [['programa'], 'exist', 'skipOnError' => true, 'targetClass' => Programa::className(), 'targetAttribute' => ['programa' => 'id']],
            [['unidad'], 'exist', 'skipOnError' => true, 'targetClass' => Unidad::className(), 'targetAttribute' => ['unidad' => 'id']],
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
            'unidad' => 'Unidad',
            'programa' => 'Programa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograma0()
    {
        return $this->hasOne(Programa::className(), ['id' => 'programa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidad0()
    {
        return $this->hasOne(Unidad::className(), ['id' => 'unidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemaunidads()
    {
        return $this->hasMany(Temaunidad::className(), ['detalleunidad' => 'id']);
    }
}
