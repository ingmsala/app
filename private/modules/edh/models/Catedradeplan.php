<?php

namespace app\modules\edh\models;


use Yii;
use app\models\Catedra;

/**
 * This is the model class for table "catedradeplan".
 *
 * @property int $id
 * @property int $catedra
 * @property int $plan
 *
 * @property Catedra $catedra0
 * @property Plancursado $plan0
 */
class Catedradeplan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catedradeplan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catedra', 'plan'], 'required'],
            [['catedra', 'plan'], 'integer'],
            [['catedra'], 'exist', 'skipOnError' => true, 'targetClass' => Catedra::className(), 'targetAttribute' => ['catedra' => 'id']],
            [['plan'], 'exist', 'skipOnError' => true, 'targetClass' => Plancursado::className(), 'targetAttribute' => ['plan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catedra' => 'Materia',
            'plan' => 'Plan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatedra0()
    {
        return $this->hasOne(Catedra::className(), ['id' => 'catedra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan0()
    {
        return $this->hasOne(Plancursado::className(), ['id' => 'plan']);
    }
}
