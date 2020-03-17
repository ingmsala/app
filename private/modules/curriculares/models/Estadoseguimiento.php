<?php

namespace app\modules\curriculares\models;

use Yii;

/**
 * This is the model class for table "estadoseguimiento".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Seguimiento[] $seguimientos
 */
class Estadoseguimiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadoseguimiento';
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
        return $this->hasMany(Seguimiento::className(), ['estadoseguimiento' => 'id']);
    }
}
