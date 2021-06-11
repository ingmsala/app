<?php

namespace app\modules\sociocomunitarios\models;

use Yii;

/**
 * This is the model class for table "calificacionactpsc".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Detalleactividadpsc[] $detalleactividadpscs
 */
class Calificacionactpsc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calificacionactpsc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 100],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleactividadpscs()
    {
        return $this->hasMany(Detalleactividadpsc::className(), ['calificacion' => 'id']);
    }
}
