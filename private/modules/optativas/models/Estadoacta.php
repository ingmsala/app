<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "estadoacta".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Acta[] $actas
 */
class Estadoacta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadoacta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 10],
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
    public function getActas()
    {
        return $this->hasMany(Acta::className(), ['estadoacta' => 'id']);
    }
}
