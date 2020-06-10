<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "localidad".
 *
 * @property int $id
 * @property string $nombre
 * @property int $provincia
 *
 * @property Docente[] $docentes
 */
class Localidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'localidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'provincia'], 'required'],
            [['provincia'], 'integer'],
            [['nombre'], 'string', 'max' => 200],
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
            'provincia' => 'Provincia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocentes()
    {
        return $this->hasMany(Docente::className(), ['localidad' => 'id']);
    }
}
