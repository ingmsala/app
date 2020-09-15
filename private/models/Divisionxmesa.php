<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "divisionxmesa".
 *
 * @property int $id
 * @property int $mesaexamen
 * @property int $division
 *
 * @property Division $division0
 * @property Mesaexamen $mesaexamen0
 */
class Divisionxmesa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'divisionxmesa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mesaexamen', 'division'], 'required'],
            [['mesaexamen', 'division'], 'integer'],
            [['division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division' => 'id']],
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
            'mesaexamen' => 'Mesaexamen',
            'division' => 'Division',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivision0()
    {
        return $this->hasOne(Division::className(), ['id' => 'division']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMesaexamen0()
    {
        return $this->hasOne(Mesaexamen::className(), ['id' => 'mesaexamen']);
    }
}
