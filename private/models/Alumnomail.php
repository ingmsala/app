<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alumnomail".
 *
 * @property int $id
 * @property string $documento
 * @property int $curso
 * @property string $mail
 */
class Alumnomail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alumnomail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'documento', 'curso', 'mail'], 'required'],
            [['id', 'curso'], 'integer'],
            [['documento'], 'string', 'max' => 8],
            [['mail'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'documento' => 'Documento',
            'curso' => 'Curso',
            'mail' => 'Mail',
        ];
    }
}
