<?php

namespace app\modules\horarioespecial\models;

use Yii;

/**
 * This is the model class for table "grupodivision".
 *
 * @property int $id
 * @property int $nombre
 * @property int $habilitacionce
 *
 * @property Habilitacionce $habilitacionce0
 */
class Grupodivision extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupodivision';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'habilitacionce'], 'required'],
            [['nombre', 'habilitacionce'], 'integer'],
            [['habilitacionce'], 'exist', 'skipOnError' => true, 'targetClass' => Habilitacionce::className(), 'targetAttribute' => ['habilitacionce' => 'id']],
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
            'habilitacionce' => 'Habilitacionce',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHabilitacionce0()
    {
        return $this->hasOne(Habilitacionce::className(), ['id' => 'habilitacionce']);
    }

    
}
