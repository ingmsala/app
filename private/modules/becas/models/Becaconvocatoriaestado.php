<?php

namespace app\modules\becas\models;

use Yii;

/**
 * This is the model class for table "becaconvocatoriaestado".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Becaconvocatoria[] $becaconvocatorias
 */
class Becaconvocatoriaestado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becaconvocatoriaestado';
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
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecaconvocatorias()
    {
        return $this->hasMany(Becaconvocatoria::className(), ['becaconvocatoriaestado' => 'id']);
    }
}
