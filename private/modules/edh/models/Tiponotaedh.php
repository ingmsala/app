<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "tiponotaedh".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Notaedh[] $notaedhs
 */
class Tiponotaedh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tiponotaedh';
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
    public function getNotaedhs()
    {
        return $this->hasMany(Notaedh::className(), ['tiponota' => 'id']);
    }
}
