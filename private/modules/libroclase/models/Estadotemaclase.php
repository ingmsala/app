<?php

namespace app\modules\libroclase\models;

use app\modules\libroclase\models\desarrollo\Detalledesarrollo;
use Yii;

/**
 * This is the model class for table "estadotemaclase".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Detalledesarrollo[] $detalledesarrollos
 */
class Estadotemaclase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadotemaclase';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalledesarrollos()
    {
        return $this->hasMany(Detalledesarrollo::className(), ['estado' => 'id']);
    }
}
