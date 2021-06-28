<?php

namespace app\modules\ticket\models;

use Yii;

/**
 * This is the model class for table "estadoauthpago".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Authpago[] $authpagos
 */
class Estadoauthpago extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadoauthpago';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 75],
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
    public function getAuthpagos()
    {
        return $this->hasMany(Authpago::className(), ['estado' => 'id']);
    }
}
