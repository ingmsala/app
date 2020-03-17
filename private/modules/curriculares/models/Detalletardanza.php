<?php

namespace app\modules\curriculares\models;

use Yii;

/**
 * This is the model class for table "detalletardanza".
 *
 * @property int $id
 * @property int $matricula
 * @property int $clase
 * @property int $tardanza
 */
class Detalletardanza extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalletardanza';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['matricula', 'clase', 'tardanza'], 'required'],
            [['matricula', 'clase', 'tardanza'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'matricula' => 'Matricula',
            'clase' => 'Clase',
            'tardanza' => 'Tardanza',
        ];
    }
}
