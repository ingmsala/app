<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "curso".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Materia[] $materias
 */
class Curso extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'curso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 150],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterias()
    {
        return $this->hasMany(Materia::className(), ['curso' => 'id']);
    }
}
