<?php

namespace app\modules\solicitudprevios\models;

use Yii;

/**
 * This is the model class for table "estadodetallesolicitudext".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Estadoxsolicitudext[] $estadoxsolicitudexts
 */
class Estadodetallesolicitudext extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadodetallesolicitudext';
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
    public function getEstadoxsolicitudexts()
    {
        return $this->hasMany(Estadoxsolicitudext::className(), ['estado' => 'id']);
    }
}
