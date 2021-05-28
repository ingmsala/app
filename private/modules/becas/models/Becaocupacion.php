<?php

namespace app\modules\becas\models;

use Yii;

/**
 * This is the model class for table "becaocupacion".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Becaocupacionpersona[] $becaocupacionpersonas
 */
class Becaocupacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becaocupacion';
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
    public function getBecaocupacionpersonas()
    {
        return $this->hasMany(Becaocupacionpersona::className(), ['ocupacion' => 'id']);
    }
}
