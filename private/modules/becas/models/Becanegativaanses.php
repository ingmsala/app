<?php

namespace app\modules\becas\models;

use Yii;

/**
 * This is the model class for table "becanegativaanses".
 *
 * @property int $id
 * @property string $url
 * @property int $persona
 * @property string $nombre
 *
 * @property Becaalumno[] $becaalumnos
 * @property Becaconviviente[] $becaconvivientes
 * @property Becapersona $persona0
 * @property Becasolicitante[] $becasolicitantes
 */
class Becanegativaanses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becanegativaanses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'nombre', 'solicitud'], 'required'],
            [['persona', 'solicitud'], 'integer'],
            [['url', 'nombre'], 'string', 'max' => 300],
            [['url'], 'unique'],
            [['persona'], 'exist', 'skipOnError' => true, 'targetClass' => Becapersona::className(), 'targetAttribute' => ['persona' => 'id']],
            [['solicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Becasolicitud::className(), 'targetAttribute' => ['solicitud' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'persona' => 'Persona',
            'nombre' => 'Nombre',
            'solicitud' => 'Solicitud',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecaalumnos()
    {
        return $this->hasMany(Becaalumno::className(), ['negativaanses' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecaconvivientes()
    {
        return $this->hasMany(Becaconviviente::className(), ['negativaanses' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersona0()
    {
        return $this->hasOne(Becapersona::className(), ['id' => 'persona']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecasolicitud0()
    {
        return $this->hasOne(Becasolicitud::className(), ['id' => 'solicitud']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecasolicitantes()
    {
        return $this->hasMany(Becasolicitante::className(), ['negativaanses' => 'id']);
    }
}
