<?php

namespace app\modules\becas\models;

use Yii;

/**
 * This is the model class for table "becaayudapersona".
 *
 * @property int $id
 * @property int $persona
 * @property int $ayuda
 *
 * @property Becaayudaestatal $ayuda0
 * @property Becapersona $persona0
 */
class Becaayudapersona extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becaayudapersona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['persona', 'ayuda'], 'required'],
            [['persona', 'ayuda'], 'integer'],
            [['ayuda'], 'exist', 'skipOnError' => true, 'targetClass' => Becaayudaestatal::className(), 'targetAttribute' => ['ayuda' => 'id']],
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
            'ayuda' => 'Ayuda',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAyuda0()
    {
        return $this->hasOne(Becaayudaestatal::className(), ['id' => 'ayuda']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersona0()
    {
        return $this->hasOne(Becapersona::className(), ['id' => 'persona']);
    }
}
