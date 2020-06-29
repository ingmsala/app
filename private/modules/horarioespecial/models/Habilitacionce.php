<?php

namespace app\modules\horarioespecial\models;
use app\models\Division;
use Yii;

/**
 * This is the model class for table "habilitacionce".
 *
 * @property int $id
 * @property int $division
 * @property string $fecha
 * @property int $estado
 *
 * @property Detallehabilitacion[] $detallehabilitacions
 * @property Division $division0
 */
class Habilitacionce extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'habilitacionce';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['division', 'fecha', 'estado'], 'required'],
            [['division', 'estado'], 'integer'],
            [['fecha'], 'safe'],
            [['division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'division' => 'Division',
            'fecha' => 'Fecha',
            'estado' => 'Estado',
        ];
    }

    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivision0()
    {
        return $this->hasOne(Division::className(), ['id' => 'division']);
    }

    public function getGrupodivisions()
    {
        return $this->hasMany(Grupodivision::className(), ['habilitacionce' => 'id']);
    }
}
