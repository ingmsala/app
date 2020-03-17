<?php

namespace app\modules\curriculares\models;

use Yii;

/**
 * This is the model class for table "aniolectivo".
 *
 * @property int $id
 * @property int $nombre
 *
 * @property Espaciocurricular[] $espaciocurriculars
 */
class Aniolectivo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aniolectivo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'activo'], 'required'],
            [['nombre', 'activo'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Año Lectivo',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspaciocurriculars()
    {
        return $this->hasMany(Espaciocurricular::className(), ['aniolectivo' => 'id']);
    }

    public function getLibroactas()
    {
        return $this->hasMany(Libroacta::className(), ['aniolectivo' => 'id']);
    }
}
