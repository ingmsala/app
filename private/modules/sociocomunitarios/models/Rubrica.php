<?php

namespace app\modules\sociocomunitarios\models;

use Yii;

/**
 * This is the model class for table "rubrica".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $curso
 *
 * @property Calificacionrubrica[] $calificacionrubricas
 * @property Detallerubrica[] $detallerubricas
 */
class Rubrica extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rubrica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'curso'], 'required'],
            [['descripcion'], 'string'],
            [['curso'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'curso' => 'Curso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacionrubricas()
    {
        return $this->hasMany(Calificacionrubrica::className(), ['rubrica' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallerubricas()
    {
        return $this->hasMany(Detallerubrica::className(), ['rubrica' => 'id']);
    }
}
