<?php

namespace app\modules\curriculares\models;

use app\models\Division;
use app\models\Matriculasecundario;
use Yii;

/**
 * This is the model class for table "alumno".
 *
 * @property int $id
 * @property string $apellido
 * @property string $nombre
 * @property int $documento
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
            [['apellido', 'nombre', 'documento', 'curso'], 'required'],
            [['documento', 'curso'], 'integer'],
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
            'documento' => 'Documento',
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

    public function getAdmisionoptativas()
    {
        return $this->hasMany(Admisionoptativa::className(), ['alumno' => 'id']);
    }

    public function getAdmisionsociocoms()
    {
        return $this->hasMany(Admisionsociocom::className(), ['alumno' => 'id']);
    }

    public function getTutors()
    {
        return $this->hasMany(Tutor::className(), ['alumno' => 'id']);
    }

    public function getDivision0()
    {
        return $this->hasOne(Division::className(), ['id' => 'curso']);
    }

    public function getNombrecompleto()
    {
        return $this->apellido.', '.$this->nombre;
    }

    public function matriculaactual($aniolectivo)
    {
       
       return Matriculasecundario::find()
                        ->where(['aniolectivo' => $aniolectivo])
                        ->andWhere(['alumno' => $this->id])
                        ->one();
        if($mat != null){
            return $mat->division0->nombre;
        }
        return 'Sin división';
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
        unset($fields['documento']);

        return $fields;
    }
}
