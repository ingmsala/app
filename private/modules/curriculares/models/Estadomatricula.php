<?php

namespace app\modules\curriculares\models;

use Yii;

/**
 * This is the model class for table "estadomatricula".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Matricula[] $matriculas
 */
class Estadomatricula extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadomatricula';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 50],
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
    public function getMatriculas()
    {
        return $this->hasMany(Matricula::className(), ['estadomatricula' => 'id']);
    }
}
