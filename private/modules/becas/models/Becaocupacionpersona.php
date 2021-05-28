<?php

namespace app\modules\becas\models;

use Yii;

/**
 * This is the model class for table "becaocupacionpersona".
 *
 * @property int $id
 * @property int $persona
 * @property int $ocupacion
 *
 * @property Becaocupacion $ocupacion0
 * @property Becapersona $persona0
 */
class Becaocupacionpersona extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becaocupacionpersona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['persona', 'ocupacion'], 'required'],
            [['persona', 'ocupacion'], 'integer'],
            [['ocupacion'], 'exist', 'skipOnError' => true, 'targetClass' => Becaocupacion::className(), 'targetAttribute' => ['ocupacion' => 'id']],
            [['persona'], 'exist', 'skipOnError' => true, 'targetClass' => Becapersona::className(), 'targetAttribute' => ['persona' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'persona' => 'Persona',
            'ocupacion' => 'Ocupacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOcupacion0()
    {
        return $this->hasOne(Becaocupacion::className(), ['id' => 'ocupacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersona0()
    {
        return $this->hasOne(Becapersona::className(), ['id' => 'persona']);
    }
}
