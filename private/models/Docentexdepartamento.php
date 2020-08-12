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
 * @property Docente $docente0
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
            [['docente', 'funciondepto', 'activo', 'departamento'], 'required'],
            [['docente', 'funciondepto', 'activo', 'departamento'], 'integer'],
            [['docente'], 'exist', 'skipOnError' => true, 'targetClass' => Docente::className(), 'targetAttribute' => ['docente' => 'id']],
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
            'docente' => 'Docente',
            'funciondepto' => 'Funciondepto',
            'activo' => 'Activo',
            'departamento' => 'Departamento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocente0()
    {
        return $this->hasOne(Docente::className(), ['id' => 'docente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunciondepto0()
    {
        return $this->hasOne(Funciondpto::className(), ['id' => 'funciondepto']);
    }
}
