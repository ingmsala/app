<?php

namespace app\modules\horarioespecial\models;

use Yii;

/**
 * This is the model class for table "horarioclaseespecial".
 *
 * @property int $id
 * @property string $inicio
 * @property string $fin
 * @property string $codigo
 *
 * @property Detallemodulo[] $detallemodulos
 */
class Horarioclaseespecial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horarioclaseespecial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inicio', 'fin'], 'required'],
            [['inicio', 'fin', 'codigo'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inicio' => 'Inicio',
            'fin' => 'Fin',
            'codigo' => 'Código',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallemodulos()
    {
        return $this->hasMany(Detallemodulo::className(), ['horarioclaseespecial' => 'id']);
    }
}
