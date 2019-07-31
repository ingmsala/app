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

    public function getContactoalumnos()
    {
        return $this->hasMany(Contactoalumno::className(), ['alumno' => 'id']);
    }

    public function fields()
    {
        $fields = [
            // el nombre de campo es el mismo nombre del atributo
            'id',
            // el nombre del campo es "email", su atributo se denomina "email_address"
            'lastName' => 'apellido',
            // el nombre del campo es "name", su valor es definido está definido por una función anónima de retrollamada (callback)
            'name' => 'nombre',
            'course' => 'curso',
            'birdDate' => 'fechanac',
        ];

        // quita los campos con información sensible
        unset($fields['dni']);

        return $fields;
    }
}
