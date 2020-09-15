<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tribunal".
 *
 * @property int $id
 * @property int $docente
 * @property int $mesaexamen
 *
 * @property Docente $docente0
 * @property Mesaexamen $mesaexamen0
 */
class Tribunal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tribunal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['docente', 'mesaexamen'], 'required'],
            [['docente', 'mesaexamen'], 'integer'],
            [['docente'], 'exist', 'skipOnError' => true, 'targetClass' => Docente::className(), 'targetAttribute' => ['docente' => 'id']],
            [['mesaexamen'], 'exist', 'skipOnError' => true, 'targetClass' => Mesaexamen::className(), 'targetAttribute' => ['mesaexamen' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'docente' => 'Docente',
            'mesaexamen' => 'Mesaexamen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocente0()
    {
        return $this->hasOne(Docente::className(), ['id' => 'docente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMesaexamen0()
    {
        return $this->hasOne(Mesaexamen::className(), ['id' => 'mesaexamen']);
    }
}
