<?php

namespace app\modules\curriculares\models;

use Yii;

/**
 * This is the model class for table "contactoalumno".
 *
 * @property int $id
 * @property string $apellido
 * @property string $nombre
 * @property string $mail
 * @property string $telefono
 * @property string $parentezco
 * @property int $alumno
 *
 * @property Alumno $alumno0
 */
class Tutor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tutor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'alumno'], 'integer'],
            [['apellido', 'nombre', 'mail'], 'string', 'max' => 150],
            [['telefono'], 'string', 'max' => 40],
            [['parentezco'], 'string', 'max' => 30],
            [['id'], 'unique'],
            [['alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumno::className(), 'targetAttribute' => ['alumno' => 'id']],
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
            'mail' => 'Mail',
            'telefono' => 'Telefono',
            'parentezco' => 'Parentezco',
            'alumno' => 'Alumno',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno0()
    {
        return $this->hasOne(Alumno::className(), ['id' => 'alumno']);
    }
}
