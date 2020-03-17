<?php

namespace app\modules\curriculares\models;

use Yii;

/**
 * This is the model class for table "comision".
 *
 * @property int $id
 * @property string $nombre
 * @property int $espaciocurricular
 * @property int $cupo
 *
 * @property Clase[] $clases
 * @property Espaciocurricular $espaciocurricular0
 * @property Docentexcomision[] $docentexcomisions
 * @property Matricula[] $matriculas
 */
class Comision extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comision';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'espaciocurricular'], 'required'],
            [['espaciocurricular', 'cupo'], 'integer'],
            [['horario'], 'string'], 
            [['aula'], 'string', 'max' => 150], 
            [['nombre'], 'string', 'max' => 20],
            [['espaciocurricular'], 'exist', 'skipOnError' => true, 'targetClass' => Espaciocurricular::className(), 'targetAttribute' => ['espaciocurricular' => 'id']],
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
            'espaciocurricular' => 'Espacio curricular',
            'cupo' => 'Cupo',

            'horario' => 'Horario', 
            'aula' => 'Aula', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClases()
    {
        return $this->hasMany(Clase::className(), ['comision' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspaciocurricular0()
    {
        return $this->hasOne(Espaciocurricular::className(), ['id' => 'espaciocurricular']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocentexcomisions()
    {
        return $this->hasMany(Docentexcomision::className(), ['comision' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatriculas()
    {
        return $this->hasMany(Matricula::className(), ['comision' => 'id']);
    }

    public function getActas()
    {
        return $this->hasMany(Acta::className(), ['comision' => 'id']);
    }
}
