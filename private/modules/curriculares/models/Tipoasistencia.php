<?php

namespace app\modules\curriculares\models;

use Yii;

/**
 * This is the model class for table "tipoasistencia".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Clase[] $clases
 */
class Tipoasistencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipoasistencia';
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
    public function getClases()
    {
        return $this->hasMany(Clase::className(), ['tipoasistencia' => 'id']);
    }
}
