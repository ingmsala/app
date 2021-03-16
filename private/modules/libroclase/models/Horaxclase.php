<?php

namespace app\modules\libroclase\models;


use Yii;
use app\models\Hora;

/**
 * This is the model class for table "horaxclase".
 *
 * @property int $id
 * @property int $clasediaria
 * @property int $hora
 *
 * @property Clasediaria $clasediaria0
 * @property Hora $hora0
 */
class Horaxclase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horaxclase';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clasediaria', 'hora'], 'required'],
            [['clasediaria', 'hora'], 'integer'],
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
            'clasediaria' => 'Clasediaria',
            'hora' => 'Horas',
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
