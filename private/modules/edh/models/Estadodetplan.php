<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "estadodetplan".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Detalleplancursado[] $detalleplancursados
 */
class Estadodetplan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadodetplan';
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
    public function getDetalleplancursados()
    {
        return $this->hasMany(Detalleplancursado::className(), ['estadodetplan' => 'id']);
    }
}
