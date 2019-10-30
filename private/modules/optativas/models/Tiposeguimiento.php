<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "tiposeguimiento".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Seguimiento[] $seguimientos
 */
class Tiposeguimiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tiposeguimiento';
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
    public function getSeguimientos()
    {
        return $this->hasMany(Seguimiento::className(), ['tiposeguimiento' => 'id']);
    }
}
