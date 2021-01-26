<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "tipoplancursado".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Plancursado[] $plancursados
 */
class Tipoplancursado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipoplancursado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 30],
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
    public function getPlancursados()
    {
        return $this->hasMany(Plancursado::className(), ['tipoplan' => 'id']);
    }
}
