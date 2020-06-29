<?php

namespace app\modules\horarioespecial\models;

use Yii;

/**
 * This is the model class for table "moduloclase".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Detallemodulo[] $detallemodulos
 */
class Moduloclase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moduloclase';
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
    public function getDetallemodulos()
    {
        return $this->hasMany(Detallemodulo::className(), ['moduloclase' => 'id']);
    }
}
