<?php

namespace app\modules\libroclase\models;

use Yii;

/**
 * This is the model class for table "modalidadclase".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Clasediaria[] $clasediarias
 */
class Modalidadclase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modalidadclase';
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
            'nombre' => 'Modalidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasediarias()
    {
        return $this->hasMany(Clasediaria::className(), ['modalidadclase' => 'id']);
    }
}
