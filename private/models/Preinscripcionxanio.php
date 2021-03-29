<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preinscripcionxanio".
 *
 * @property int $id
 * @property int $anio
 * @property int $preinscripcion
 *
 * @property Preinscripcion $preinscripcion0
 */
class Preinscripcionxanio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'preinscripcionxanio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['anio', 'preinscripcion'], 'required'],
            [['anio', 'preinscripcion'], 'integer'],
            [['preinscripcion'], 'exist', 'skipOnError' => true, 'targetClass' => Preinscripcion::className(), 'targetAttribute' => ['preinscripcion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'anio' => 'Años',
            'preinscripcion' => 'Preinscripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreinscripcion0()
    {
        return $this->hasOne(Preinscripcion::className(), ['id' => 'preinscripcion']);
    }
}
