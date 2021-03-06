<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "condicion".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Detallecatedra[] $detallecatedras
 * @property Nombramiento[] $nombramientos
 */
class Condicion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'condicion';
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
    public function getDetallecatedras()
    {
        return $this->hasMany(Detallecatedra::className(), ['condicion' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNombramientos()
    {
        return $this->hasMany(Nombramiento::className(), ['condicion' => 'id']);
    }

    public function getAgentes()
    {
        return $this->hasMany(Agente::className(), ['id' => 'condicion'])->via('detallecatedras');
    }
}
