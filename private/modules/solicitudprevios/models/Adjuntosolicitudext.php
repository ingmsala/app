<?php

namespace app\modules\solicitudprevios\models;

use Yii;

/**
 * This is the model class for table "adjuntosolicitudext".
 *
 * @property int $id
 * @property string $url
 * @property int $solicitud
 * @property string $nombre
 *
 * @property Solicitudinscripext $solicitud0
 */
class Adjuntosolicitudext extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adjuntosolicitudext';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'nombre', 'image'], 'required'],
            [['solicitud'], 'integer'],
            [['url', 'nombre'], 'string', 'max' => 300],
            [['url'], 'unique'],
            [['solicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitudinscripext::className(), 'targetAttribute' => ['solicitud' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'url' => 'Url',
            'solicitud' => 'Solicitud',
            'nombre' => 'Nombre',
            'image' => 'Adjuntar copia del DNI (actualizado y de ambos lados)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitud0()
    {
        return $this->hasOne(Solicitudinscripext::className(), ['id' => 'solicitud']);
    }
}
