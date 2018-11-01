<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "docente".
 *
 * @property int $id
 * @property string $legajo
 * @property string $apellido
 * @property string $nombre
 * @property int $genero
 *
 * @property Detallecatedra[] $detallecatedras
 * @property Genero $genero0
 * @property Nombramiento[] $nombramientos
 */
class Docente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'docente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido', 'nombre', 'genero'], 'required'],
            [['genero'], 'integer'],
            [['legajo'], 'string', 'max' => 8],
            [['apellido', 'nombre'], 'string', 'max' => 70],
            [['legajo'], 'unique'],
            [['genero'], 'exist', 'skipOnError' => true, 'targetClass' => Genero::className(), 'targetAttribute' => ['genero' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'legajo' => 'Legajo',
            'apellido' => 'Apellido',
            'nombre' => 'Nombre',
            'genero' => 'Genero',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallecatedras()
    {
        return $this->hasMany(Detallecatedra::className(), ['docente' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenero0()
    {
        return $this->hasOne(Genero::className(), ['id' => 'genero']);
    }

    public function getCatedras()
    {
        return $this->hasMany(Catedra::className(), ['id' => 'docente'])->via('detallecatedras');
    }

    public function getCondicions()
    {
        return $this->hasMany(Condicion::className(), ['id' => 'condicion'])->via('detallecatedras');
    }

    public function getNombramientos()
    {
        return $this->hasMany(Nombramiento::className(), ['docente' => 'id']);
    }


   
}
