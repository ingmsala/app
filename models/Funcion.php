<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "funcion".
 *
 * @property int $id
 * @property string $nombre
 * @property int $cargo
 * @property int $horas
 * @property int $docente
 * @property int $revista
 * @property int $division
 *
 * @property Revista $revista0
 * @property Cargo $cargo0
 * @property Docente $docente0
 * @property Division $division0
 */
class Funcion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'funcion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cargo', 'horas', 'docente', 'revista'], 'required'],
            [['id', 'cargo', 'horas', 'docente', 'revista', 'division'], 'integer'],
            [['nombre'], 'string', 'max' => 150],
            [['id'], 'unique'],
            [['revista'], 'exist', 'skipOnError' => true, 'targetClass' => Revista::className(), 'targetAttribute' => ['revista' => 'id']],
            [['cargo'], 'exist', 'skipOnError' => true, 'targetClass' => Cargo::className(), 'targetAttribute' => ['cargo' => 'id']],
            [['docente'], 'exist', 'skipOnError' => true, 'targetClass' => Docente::className(), 'targetAttribute' => ['docente' => 'id']],
            [['division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division' => 'id']],
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
            'cargo' => 'Cargo',
            'horas' => 'Horas',
            'docente' => 'Docente',
            'revista' => 'Revista',
            'division' => 'Division',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRevista0()
    {
        return $this->hasOne(Revista::className(), ['id' => 'revista']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargo0()
    {
        return $this->hasOne(Cargo::className(), ['id' => 'cargo']);
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
    public function getDivision0()
    {
        return $this->hasOne(Division::className(), ['id' => 'division']);
    }
}
