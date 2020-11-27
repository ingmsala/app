<?php

namespace app\modules\mones\models;

use Yii;

/**
 * This is the model class for table "moncarrera".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Monmateria[] $monmaterias
 */
class Moncarrera extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moncarrera';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nombre'], 'required'],
            [['id'], 'integer'],
            [['nombre'], 'string', 'max' => 75],
            [['id'], 'unique'],
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
    public function getMonmaterias()
    {
        return $this->hasMany(Monmateria::className(), ['carrera' => 'id']);
    }

    public function getMonmatriculas()
    {
        return $this->hasMany(Monmatricula::className(), ['carrera' => 'id']);
    }
}
