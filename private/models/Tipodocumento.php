<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipodocumento".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Docente[] $docentes
 */
class Tipodocumento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipodocumento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 30],
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
    public function getDocentes()
    {
        return $this->hasMany(Docente::className(), ['tipodocumento' => 'id']);
    }
}
