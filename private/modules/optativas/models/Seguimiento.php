<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "seguimiento".
 *
 * @property int $id
 * @property int $matricula
 * @property string $fecha
 * @property int $descripci贸n
 *
 * @property Matricula $matricula0
 */
class Seguimiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguimiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['matricula', 'fecha', 'descripci贸n'], 'required'],
            [['matricula', 'descripci贸n'], 'integer'],
            [['fecha'], 'safe'],
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
            'fecha' => 'Fecha',
            'descripci贸n' => 'Descripci愠n',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatricula0()
    {
        return $this->hasOne(Matricula::className(), ['id' => 'matricula']);
    }
}
