<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "adjuntocertificacion".
 *
 * @property int $id
 * @property string $url
 * @property int $certificacion
 * @property string $nombre
 *
 * @property Certificacionedh $certificacion0
 */
class Adjuntocertificacion extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adjuntocertificacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'nombre'], 'required'],
            [['certificacion'], 'integer'],
            [['image'], 'safe'],
            [['url', 'nombre'], 'string', 'max' => 300],
            [['url'], 'unique'],
            [['certificacion'], 'exist', 'skipOnError' => true, 'targetClass' => Certificacionedh::className(), 'targetAttribute' => ['certificacion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'certificacion' => 'Certificacion',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertificacion0()
    {
        return $this->hasOne(Certificacionedh::className(), ['id' => 'certificacion']);
    }
}
