<?php

namespace app\modules\becas\models;

use Yii;

/**
 * This is the model class for table "becatipobeca".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Becaconvocatoria[] $becaconvocatorias
 */
class Becatipobeca extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becatipobeca';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 70],
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
    public function getBecaconvocatorias()
    {
        return $this->hasMany(Becaconvocatoria::className(), ['becatipobeca' => 'id']);
    }
}
