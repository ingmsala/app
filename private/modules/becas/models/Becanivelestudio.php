<?php

namespace app\modules\becas\models;

use Yii;

/**
 * This is the model class for table "becanivelestudio".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Becaalumno[] $becaalumnos
 * @property Becaconviviente[] $becaconvivientes
 * @property Becasolicitante[] $becasolicitantes
 */
class Becanivelestudio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becanivelestudio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 70],
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
    public function getBecaalumnos()
    {
        return $this->hasMany(Becaalumno::className(), ['nivelestudio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecaconvivientes()
    {
        return $this->hasMany(Becaconviviente::className(), ['nivelestudio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecasolicitantes()
    {
        return $this->hasMany(Becasolicitante::className(), ['nivelestudio' => 'id']);
    }
}
