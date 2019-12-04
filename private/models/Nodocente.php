<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nodocente".
 *
 * @property int $id
 * @property string $legajo
 * @property string $apellido
 * @property string $nombre
 * @property int $genero
 * @property string $documento
 * @property string $mail 

 * @property Tareamantenimiento[] $tareamantenimientos
 */
class Nodocente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nodocente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido', 'nombre', 'genero', 'documento'], 'required'],
            [['genero'], 'integer'],
            [['legajo', 'documento'], 'string', 'max' => 8],
            [['apellido', 'nombre'], 'string', 'max' => 70],
            [['mail'], 'string', 'max' => 150],
            ['mail', 'email'],
            [['genero'], 'exist', 'skipOnError' => true, 'targetClass' => Genero::className(), 'targetAttribute' => ['genero' => 'id']],
            [['documento'], 'unique'],
            [['legajo'], 'unique'],
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
            'documento' => 'Documento',
            'mail' => 'Mail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTareamantenimientos()
    {
        return $this->hasMany(Tareamantenimiento::className(), ['responsable' => 'id']);
    }

    public function getGenero0()
    {
        return $this->hasOne(Genero::className(), ['id' => 'genero']);
    }
}
