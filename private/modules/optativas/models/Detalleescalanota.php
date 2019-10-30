<?php

namespace app\modules\optativas\models;

use Yii;

/**
 * This is the model class for table "detalleescalanota".
 *
 * @property int $id
 * @property string $nota
 * @property int $escalanota
 * @property int $condicionnota
 *
 * @property Detalleacta[] $detalleactas
 * @property Escalanota $escalanota0
 * @property Condicionnota $condicionnota0
 */
class Detalleescalanota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalleescalanota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nota', 'escalanota', 'condicionnota'], 'required'],
            [['escalanota', 'condicionnota'], 'integer'],
            [['nota'], 'string', 'max' => 30],
            [['escalanota'], 'exist', 'skipOnError' => true, 'targetClass' => Escalanota::className(), 'targetAttribute' => ['escalanota' => 'id']],
            [['condicionnota'], 'exist', 'skipOnError' => true, 'targetClass' => Condicionnota::className(), 'targetAttribute' => ['condicionnota' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nota' => 'Nota',
            'escalanota' => 'Escala de nota',
            'condicionnota' => 'Condicion de nota',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleactas()
    {
        return $this->hasMany(Detalleacta::className(), ['detalleescala' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEscalanota0()
    {
        return $this->hasOne(Escalanota::className(), ['id' => 'escalanota']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCondicionnota0()
    {
        return $this->hasOne(Condicionnota::className(), ['id' => 'condicionnota']);
    }
}
