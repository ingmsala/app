<?php

namespace app\modules\becas\models;

use Yii;

/**
 * This is the model class for table "becapersona".
 *
 * @property int $id
 *
 * @property Becaalumno[] $becaalumnos
 * @property Becaayudapersona[] $becaayudapersonas
 * @property Becaconviviente[] $becaconvivientes
 * @property Becanegativaanses[] $becanegativaanses
 * @property Becaocupacionpersona[] $becaocupacionpersonas
 * @property Becasolicitante[] $becasolicitantes
 */
class Becapersona extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becapersona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecaalumnos()
    {
        return $this->hasMany(Becaalumno::className(), ['persona' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecaayudapersonas()
    {
        return $this->hasMany(Becaayudapersona::className(), ['persona' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecaconvivientes()
    {
        return $this->hasMany(Becaconviviente::className(), ['persona' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecanegativaanses()
    {
        return $this->hasMany(Becanegativaanses::className(), ['persona' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecaocupacionpersonas()
    {
        return $this->hasMany(Becaocupacionpersona::className(), ['persona' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecasolicitantes()
    {
        return $this->hasMany(Becasolicitante::className(), ['persona' => 'id']);
    }
}
