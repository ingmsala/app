<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "funciondj".
 *
 * @property int $id
 * @property string $reparticion
 * @property string $cargo
 * @property double $horas
 * @property int $declaracionjurada
 *
 * @property Declaracionjurada $declaracionjurada0
 * @property Horariodj[] $horariodjs
 */
class Funciondj extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'funciondj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['reparticion', 'cargo', 'horas', 'declaracionjurada'], 'required'],
            [['horas'], 'number'],
            [['declaracionjurada'], 'integer'],
            [['reparticion', 'cargo'], 'string', 'max' => 250],
            [['declaracionjurada'], 'exist', 'skipOnError' => true, 'targetClass' => Declaracionjurada::className(), 'targetAttribute' => ['declaracionjurada' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reparticion' => 'Reparticion',
            'cargo' => 'Cargo',
            'horas' => 'Horas',
            'declaracionjurada' => 'Declaracionjurada',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeclaracionjurada0()
    {
        return $this->hasOne(Declaracionjurada::className(), ['id' => 'declaracionjurada']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHorariodjs()
    {
        return $this->hasMany(Horariodj::className(), ['funciondj' => 'id']);
    }
}
