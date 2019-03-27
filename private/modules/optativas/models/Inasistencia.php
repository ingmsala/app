<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "inasistencia".
 *
 * @property int $id
 * @property int $matricula
 * @property int $clase
 *
 * @property Clase $clase0
 * @property Matricula $matricula0
 */
class Inasistencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inasistencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['matricula', 'clase'], 'required'],
            [['matricula', 'clase'], 'integer'],
            [['clase'], 'exist', 'skipOnError' => true, 'targetClass' => Clase::className(), 'targetAttribute' => ['clase' => 'id']],
            [['matricula'], 'exist', 'skipOnError' => true, 'targetClass' => Matricula::className(), 'targetAttribute' => ['matricula' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'matricula' => 'Matricula',
            'clase' => 'Clase',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClase0()
    {
        return $this->hasOne(Clase::className(), ['id' => 'clase']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatricula0()
    {
        return $this->hasOne(Matricula::className(), ['id' => 'matricula']);
    }
}
