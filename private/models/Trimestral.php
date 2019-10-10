<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trimestral".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Anioxtrimestral[] $anioxtrimestrals
 */
class Trimestral extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trimestral';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 25],
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
    public function getAnioxtrimestrals()
    {
        return $this->hasMany(Anioxtrimestral::className(), ['trimestral' => 'id']);
    }
}
