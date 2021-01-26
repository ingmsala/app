<?php

namespace app\modules\edh\models;


use Yii;
use app\models\Catedra;

/**
 * This is the model class for table "detalleplancursado".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $catedra
 * @property int $estadodetplan
 *
 * @property Catedra $catedra0
 * @property Estadodetplan $estadodetplan0
 * @property Notaedh[] $notaedhs
 */
class Detalleplancursado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalleplancursado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'catedra', 'estadodetplan', 'plan'], 'required'],
            [['descripcion'], 'string'],
            [['catedra', 'estadodetplan', 'plan'], 'integer'],
            [['catedra'], 'exist', 'skipOnError' => true, 'targetClass' => Catedra::className(), 'targetAttribute' => ['catedra' => 'id']],
            [['estadodetplan'], 'exist', 'skipOnError' => true, 'targetClass' => Estadodetplan::className(), 'targetAttribute' => ['estadodetplan' => 'id']],
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
            'descripcion' => 'Descripción',
            'catedra' => 'Cátedra',
            'estadodetplan' => 'Estadodetplan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan0()
    {
        return $this->hasOne(Plancursado::className(), ['id' => 'plan']);
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
    public function getEstadodetplan0()
    {
        return $this->hasOne(Estadodetplan::className(), ['id' => 'estadodetplan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotaedhs()
    {
        return $this->hasMany(Notaedh::className(), ['detalleplancursado' => 'id']);
    }
}
