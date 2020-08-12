<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "funciondpto".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Docentexdepartamento[] $docentexdepartamentos
 */
class Funciondpto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'funciondpto';
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
    public function getDocentexdepartamentos()
    {
        return $this->hasMany(Docentexdepartamento::className(), ['funciondepto' => 'id']);
    }
}
