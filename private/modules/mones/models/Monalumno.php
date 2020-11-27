<?php

namespace app\modules\mones\models;

use Yii;

/**
 * This is the model class for table "monalumno".
 *
 * @property int $documento
 * @property int $legajo
 * @property string $apellido
 * @property string $nombre
 * @property string $fechanac
 *
 * @property Monacademica[] $monacademicas
 * @property Monmatricula[] $monmatriculas
 */
class Monalumno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'monalumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['documento'], 'required'],
            [['documento', 'legajo'], 'integer'],
            [['fechanac'], 'safe'],
            [['apellido', 'nombre'], 'string', 'max' => 25],
            [['documento'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'documento' => 'Documento',
            'legajo' => 'Legajo',
            'apellido' => 'Apellido',
            'nombre' => 'Nombre',
            'fechanac' => 'Fechanac',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonacademicas()
    {
        return $this->hasMany(Monacademica::className(), ['alumno' => 'documento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonmatriculas()
    {
        return $this->hasMany(Monmatricula::className(), ['alumno' => 'documento']);
    }
}
