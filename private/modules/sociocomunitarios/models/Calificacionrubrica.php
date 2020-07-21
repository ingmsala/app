<?php

namespace app\modules\sociocomunitarios\models;

use app\modules\curriculares\models\Detalleescalanota;
use Yii;

/**
 * This is the model class for table "calificacionrubrica".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $rubrica
 *
 * @property Rubrica $rubrica0
 */
class Calificacionrubrica extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calificacionrubrica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'rubrica', 'detalleescalanota'], 'required'],
            [['descripcion'], 'string'],
            [['rubrica', 'detalleescalanota'], 'integer'],
            [['rubrica'], 'exist', 'skipOnError' => true, 'targetClass' => Rubrica::className(), 'targetAttribute' => ['rubrica' => 'id']],
            [['detalleescalanota'], 'exist', 'skipOnError' => true, 'targetClass' => Detalleescalanota::className(), 'targetAttribute' => ['detalleescalanota' => 'id']],
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
            'rubrica' => 'Rúbrica',
            'detalleescalanota' => 'Nota',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRubrica0()
    {
        return $this->hasOne(Rubrica::className(), ['id' => 'rubrica']);
    }

    public function getDetalleescalanota0()
    {
        return $this->hasOne(Detalleescalanota::className(), ['id' => 'detalleescalanota']);
    }
}
