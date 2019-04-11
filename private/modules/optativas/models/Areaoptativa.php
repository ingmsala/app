<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "areaoptativa".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Optativa[] $optativas
 */
class Areaoptativa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'areaoptativa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 200],
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
    public function getOptativas()
    {
        return $this->hasMany(Optativa::className(), ['areaoptativa' => 'id']);
    }
}
