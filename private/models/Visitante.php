<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visitante".
 *
 * @property int $id
 * @property int $dni
 * @property string $apellidos
 * @property string $nombres
 * @property int $estado
 *
 * @property Acceso[] $accesos
 * @property Restriccion[] $restriccions
 */
class Visitante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visitante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dni', 'nombres', 'estado'], 'required'],
            [['dni', 'estado'], 'integer'],
            [['apellidos', 'nombres'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dni' => 'Dni',
            'apellidos' => 'Apellidos',
            'nombres' => 'Nombres',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccesos()
    {
        return $this->hasMany(Acceso::className(), ['visitante' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestriccions()
    {
        return $this->hasMany(Restriccion::className(), ['visitante' => 'id']);
    }
}
