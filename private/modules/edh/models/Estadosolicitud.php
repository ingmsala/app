<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "estadosolicitud".
 *
 * @property string $nombre
 * @property int $id
 */
class Estadosolicitud extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadosolicitud';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 70],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'id' => 'ID',
        ];
    }
}
