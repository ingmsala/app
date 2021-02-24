<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadoturnoexamen".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Turnoexamen[] $turnoexamens
 */
class Estadoturnoexamen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadoturnoexamen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 70],
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
    public function getTurnoexamens()
    {
        return $this->hasMany(Turnoexamen::className(), ['activo' => 'id']);
    }
}
