<?php

namespace app\modules\libroclase\models;

use Yii;

/**
 * This is the model class for table "tipocurricula".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Clasediaria[] $clasediarias
 */
class Tipocurricula extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipocurricula';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 40],
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
    public function getClasediarias()
    {
        return $this->hasMany(Clasediaria::className(), ['tipocurricula' => 'id']);
    }
}
