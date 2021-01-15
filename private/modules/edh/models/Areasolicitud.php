<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "areasolicitud".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Informeprofesional[] $informeprofesionals
 * @property Solicitudedh[] $solicitudedhs
 */
class Areasolicitud extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'areasolicitud';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 150],
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
    public function getInformeprofesionals()
    {
        return $this->hasMany(Informeprofesional::className(), ['areasolicitud' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudedhs()
    {
        return $this->hasMany(Solicitudedh::className(), ['areasolicitud' => 'id']);
    }
}
