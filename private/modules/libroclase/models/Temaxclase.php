<?php

namespace app\modules\libroclase\models;

use Yii;

/**
 * This is the model class for table "temaxclase".
 *
 * @property int $id
 * @property int $clasediaria
 * @property int $temaunidad
 * @property int $tipodesarrollo
 *
 * @property Clasediaria $clasediaria0
 * @property Temaunidad $temaunidad0
 * @property Tipodesarrollo $tipodesarrollo0
 */
class Temaxclase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'temaxclase';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clasediaria', 'temaunidad', 'tipodesarrollo'], 'required'],
            [['clasediaria', 'temaunidad', 'tipodesarrollo'], 'integer'],
            [['clasediaria'], 'exist', 'skipOnError' => true, 'targetClass' => Clasediaria::className(), 'targetAttribute' => ['clasediaria' => 'id']],
            [['temaunidad'], 'exist', 'skipOnError' => true, 'targetClass' => Temaunidad::className(), 'targetAttribute' => ['temaunidad' => 'id']],
            [['tipodesarrollo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipodesarrollo::className(), 'targetAttribute' => ['tipodesarrollo' => 'id']],
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
            'temaunidad' => 'Temaunidad',
            'tipodesarrollo' => 'Tipodesarrollo',
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
    public function getTemaunidad0()
    {
        return $this->hasOne(Temaunidad::className(), ['id' => 'temaunidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipodesarrollo0()
    {
        return $this->hasOne(Tipodesarrollo::className(), ['id' => 'tipodesarrollo']);
    }
}
