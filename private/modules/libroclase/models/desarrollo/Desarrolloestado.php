<?php

namespace app\modules\libroclase\models\desarrollo;

use Yii;

/**
 * This is the model class for table "desarrolloestado".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Desarrollo[] $desarrollos
 */
class Desarrolloestado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'desarrolloestado';
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
            'nombre' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesarrollos()
    {
        return $this->hasMany(Desarrollo::className(), ['estado' => 'id']);
    }
}
