<?php

namespace app\modules\becas\models;

use Yii;

/**
 * This is the model class for table "becaayudaestatal".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Becaayudapersona[] $becaayudapersonas
 */
class Becaayudaestatal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becaayudaestatal';
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
    public function getBecaayudapersonas()
    {
        return $this->hasMany(Becaayudapersona::className(), ['ayuda' => 'id']);
    }
}
