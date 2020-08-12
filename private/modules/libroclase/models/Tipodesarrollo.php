<?php

namespace app\modules\libroclase\models;

use Yii;

/**
 * This is the model class for table "tipodesarrollo".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Clasediaria[] $clasediarias
 */
class Tipodesarrollo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipodesarrollo';
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
            'nombre' => 'Tipo de desarrollo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasediarias()
    {
        return $this->hasMany(Clasediaria::className(), ['tipodesarrollo' => 'id']);
    }
}
