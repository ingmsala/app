<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "tipoprofesional".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Certificacionedh[] $certificacionedhs
 */
class Tipoprofesional extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipoprofesional';
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
    public function getCertificacionedhs()
    {
        return $this->hasMany(Certificacionedh::className(), ['tipoprofesional' => 'id']);
    }
}
