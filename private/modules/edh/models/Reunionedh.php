<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "reunionedh".
 *
 * @property int $id
 * @property string $fecha
 * @property string $hora
 * @property string $parte
 * @property string $lugar
 * @property string $tematica
 * @property int $caso
 * @property string $url
 *
 * @property Participantereunion[] $participantereunions
 * @property Caso $caso0
 */
class Reunionedh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reunionedh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'hora', 'tematica', 'caso'], 'required'],
            [['fecha', 'hora'], 'safe'],
            [['parte'], 'string'],
            [['caso'], 'integer'],
            [['lugar', 'tematica'], 'string', 'max' => 200],
            [['url'], 'string', 'max' => 300],
            [['caso'], 'exist', 'skipOnError' => true, 'targetClass' => Caso::className(), 'targetAttribute' => ['caso' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'parte' => 'Parte',
            'lugar' => 'Lugar',
            'tematica' => 'Tematica',
            'caso' => 'Caso',
            'url' => 'Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantereunions()
    {
        return $this->hasMany(Participantereunion::className(), ['reunionedh' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaso0()
    {
        return $this->hasOne(Caso::className(), ['id' => 'caso']);
    }
}
