<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadoinasistencia".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Estadoinasistenciaxparte[] $estadoinasistenciaxpartes
 */
class Estadoinasistencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadoinasistencia';
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
    public function getEstadoinasistenciaxpartes()
    {
        return $this->hasMany(Estadoinasistenciaxparte::className(), ['estadoinasistencia' => 'id']);
    }

   
    public function getDetallepartes()
    {
        return $this->hasMany(Detalleparte::className(), ['id' => 'estadoinasistencia'])->via('estadoinasistenciaxparte');
    }

    
}
