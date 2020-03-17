<?php

namespace app\modules\curriculares\models;

use Yii;

/**
 * This is the model class for table "detalleacta".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $detalleescala
 * @property int $acta
 * @property int $matricula
 *
 * @property Acta $acta0
 * @property Detalleescalanota $detalleescala0
 * @property Matricula $matricula0
 */
class Detalleacta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalleacta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['detalleescala', 'acta', 'matricula'], 'integer'],
            [['acta', 'matricula'], 'required'],
            [['acta', 'matricula'], 'unique', 'targetAttribute' => ['acta', 'matricula']],
            [['acta'], 'exist', 'skipOnError' => true, 'targetClass' => Acta::className(), 'targetAttribute' => ['acta' => 'id']],
            [['detalleescala'], 'exist', 'skipOnError' => true, 'targetClass' => Detalleescalanota::className(), 'targetAttribute' => ['detalleescala' => 'id']],
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
            'descripcion' => 'Descripcion',
            'detalleescala' => 'Detalleescala',
            'acta' => 'Acta',
            'matricula' => 'Matricula',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActa0()
    {
        return $this->hasOne(Acta::className(), ['id' => 'acta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleescala0()
    {
        return $this->hasOne(Detalleescalanota::className(), ['id' => 'detalleescala']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatricula0()
    {
        return $this->hasOne(Matricula::className(), ['id' => 'matricula']);
    }
}
