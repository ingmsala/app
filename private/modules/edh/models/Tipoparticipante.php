<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "tipoparticipante".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Participantereunion[] $participantereunions
 */
class Tipoparticipante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipoparticipante';
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
    public function getParticipantereunions()
    {
        return $this->hasMany(Participantereunion::className(), ['tipoparticipante' => 'id']);
    }
}
