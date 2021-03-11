<?php

namespace app\modules\horariogenerico\models;

use Yii;

/**
 * This is the model class for table "burbuja".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Horariogeneric[] $horariogenerics
 */
class Burbuja extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'burbuja';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 100],
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
    public function getHorariogenerics()
    {
        return $this->hasMany(Horariogeneric::className(), ['burbuja' => 'id']);
    }
}
