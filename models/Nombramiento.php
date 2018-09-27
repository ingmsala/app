<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nombramiento".
 *
 * @property int $id
 * @property string $nombre
 * @property int $cargo
 * @property int $horas
 * @property int $docente
 * @property int $revista
 * @property int $condicion
 * @property int $division
 * @property int $suplente
 *
 * @property Condicion $condicion0
 * @property Cargo $cargo0
 * @property Docente $docente0
 * @property Division $division0
 * @property Revista $revista0
 * @property Nombramiento $suplente0
 * @property Nombramiento[] $nombramientos
 */
class Nombramiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nombramiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cargo', 'horas', 'docente', 'revista', 'condicion'], 'required'],
            [['id', 'cargo', 'horas', 'docente', 'revista', 'condicion', 'division', 'suplente'], 'integer'],
            [['nombre'], 'string', 'max' => 150],
            [['id'], 'unique'],
            [['condicion'], 'exist', 'skipOnError' => true, 'targetClass' => Condicion::className(), 'targetAttribute' => ['condicion' => 'id']],
            [['cargo'], 'exist', 'skipOnError' => true, 'targetClass' => Cargo::className(), 'targetAttribute' => ['cargo' => 'id']],
            [['docente'], 'exist', 'skipOnError' => true, 'targetClass' => Docente::className(), 'targetAttribute' => ['docente' => 'id']],
            [['division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division' => 'id']],
            [['revista'], 'exist', 'skipOnError' => true, 'targetClass' => Revista::className(), 'targetAttribute' => ['revista' => 'id']],
            [['suplente'], 'exist', 'skipOnError' => true, 'targetClass' => Nombramiento::className(), 'targetAttribute' => ['suplente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Función',
            'cargo' => 'Cargo',
            'horas' => 'Horas',
            'docente' => 'Docente',
            'revista' => 'Revista',
            'condicion' => 'Condicion',
            'division' => 'Division',
            'suplente' => 'Suplente',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCondicion0()
    {
        return $this->hasOne(Condicion::className(), ['id' => 'condicion']);
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
    public function getSuplente0()
    {
        return $this->hasOne(Nombramiento::className(), ['id' => 'suplente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNombramientos()
    {
        return $this->hasMany(Nombramiento::className(), ['suplente' => 'id']);
    }

    public function getLabel()
    {
        return '('.$this->cargo.') '.$this->docente0->apellido.', '.$this->docente0->nombre;
    }

}
