<?php

namespace app\modules\libroclase\models;

use app\models\Hora;
use Yii;

/**
 * This is the model class for table "detallehora".
 *
 * @property int $id
 * @property int $hora
 * @property int $clasediaria
 *
 * @property Clasediaria $clasediaria0
 * @property Hora $hora0
 */
class Detallehora extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detallehora';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hora', 'clasediaria'], 'required'],
            [['hora', 'clasediaria'], 'integer'],
            [['clasediaria'], 'exist', 'skipOnError' => true, 'targetClass' => Clasediaria::className(), 'targetAttribute' => ['clasediaria' => 'id']],
            [['hora'], 'exist', 'skipOnError' => true, 'targetClass' => Hora::className(), 'targetAttribute' => ['hora' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hora' => 'Hora',
            'clasediaria' => 'Clase diaria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasediaria0()
    {
        return $this->hasOne(Clasediaria::className(), ['id' => 'clasediaria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHora0()
    {
        return $this->hasOne(Hora::className(), ['id' => 'hora']);
    }
}
