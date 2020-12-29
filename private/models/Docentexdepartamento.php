<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "docentexdepartamento".
 *
 * @property int $id
 * @property int $docente
 * @property int $funciondepto
 * @property int $activo
 * @property int $departamento
 *
 * @property Agente $agente0
 * @property Funciondpto $funciondepto0
 */
class Docentexdepartamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'docentexdepartamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agente', 'funciondepto', 'activo', 'departamento'], 'required'],
            [['agente', 'funciondepto', 'activo', 'departamento'], 'integer'],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['funciondepto'], 'exist', 'skipOnError' => true, 'targetClass' => Funciondpto::className(), 'targetAttribute' => ['funciondepto' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agente' => 'Agente',
            'funciondepto' => 'Funciondepto',
            'activo' => 'Activo',
            'departamento' => 'Departamento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgente0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'agente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunciondepto0()
    {
        return $this->hasOne(Funciondpto::className(), ['id' => 'funciondepto']);
    }
}
