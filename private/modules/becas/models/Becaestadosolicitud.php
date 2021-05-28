<?php

namespace app\modules\becas\models;

use Yii;

/**
 * This is the model class for table "becaestadosolicitud".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Becaestadoxsolicitud[] $becaestadoxsolicituds
 * @property Becasolicitud[] $becasolicituds
 */
class Becaestadosolicitud extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'becaestadosolicitud';
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
    public function getBecaestadoxsolicituds()
    {
        return $this->hasMany(Becaestadoxsolicitud::className(), ['estado' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBecasolicituds()
    {
        return $this->hasMany(Becasolicitud::className(), ['estado' => 'id']);
    }
}
