<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "propuesta".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Actividad[] $actividads
 * @property Division[] $divisions
 */
class Propuesta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'propuesta';
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
    public function getActividads()
    {
        return $this->hasMany(Actividad::className(), ['propuesta' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivisions()
    {
        return $this->hasMany(Division::className(), ['propuesta' => 'id']);
    }
}
