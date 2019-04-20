<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "alumno".
 *
 * @property int $id
 * @property string $apellido
 * @property string $nombre
 * @property int $dni
 * @property int $curso
 *
 * @property Matricula[] $matriculas
 */
class Alumno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido', 'nombre', 'dni', 'curso'], 'required'],
            [['dni', 'curso'], 'integer'],
            [['fechanac'], 'safe'],
            [['apellido', 'nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'apellido' => 'Apellido',
            'nombre' => 'Nombre',
            'dni' => 'Dni',
            'curso' => 'Curso',
            'fechanac' => 'Fecha de Nacimiento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatriculas()
    {
        return $this->hasMany(Matricula::className(), ['alumno' => 'id']);
    }
}
