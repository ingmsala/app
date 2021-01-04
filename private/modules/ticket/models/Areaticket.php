<?php

namespace app\modules\ticket\models;

use Yii;

/**
 * This is the model class for table "areaticket".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Asignacionticket[] $asignaciontickets
 * @property Grupotrabajoticket[] $grupotrabajotickets
 */
class Areaticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'areaticket';
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
    public function getAsignaciontickets()
    {
        return $this->hasMany(Asignacionticket::className(), ['areaticket' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupotrabajotickets()
    {
        return $this->hasMany(Grupotrabajoticket::className(), ['areaticket' => 'id']);
    }
}
