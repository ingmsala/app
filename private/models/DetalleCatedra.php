<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detallecatedra".
 *
 * @property int $id
 * @property int $docente
 * @property int $catedra
 * @property int $condicion
 * @property int $revista
 * @property int $resolucion
 * @property string $fechaInicio
 * @property string $fechaFin
 *
 * @property Docente $docente0
 * @property Catedra $catedra0
 * @property Condicion $condicion0
 * @property Revista $revista0
 * @property Resolucion $resolucion0
 */
class Detallecatedra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detallecatedra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['docente', 'catedra', 'condicion', 'revista'], 'required'],
            [['docente', 'catedra', 'condicion', 'revista', 'resolucion'], 'integer'],
            [['fechaInicio', 'fechaFin'], 'safe'],
            [['docente'], 'exist', 'skipOnError' => true, 'targetClass' => Docente::className(), 'targetAttribute' => ['docente' => 'id']],
            [['catedra'], 'exist', 'skipOnError' => true, 'targetClass' => Catedra::className(), 'targetAttribute' => ['catedra' => 'id']],
            [['condicion'], 'exist', 'skipOnError' => true, 'targetClass' => Condicion::className(), 'targetAttribute' => ['condicion' => 'id']],
            [['revista'], 'exist', 'skipOnError' => true, 'targetClass' => Revista::className(), 'targetAttribute' => ['revista' => 'id']],
            [['resolucion'], 'exist', 'skipOnError' => true, 'targetClass' => Resolucion::className(), 'targetAttribute' => ['resolucion' => 'id']],
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
            'catedra' => 'Catedra',
            'condicion' => 'Condicion',
            'revista' => 'Revista',
            'resolucion' => 'Resolucion',
            'fechaInicio' => 'Fecha Inicio',
            'fechaFin' => 'Fecha Fin',
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
    public function getCatedra0()
    {
        return $this->hasOne(Catedra::className(), ['id' => 'catedra']);
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
    public function getRevista0()
    {
        return $this->hasOne(Revista::className(), ['id' => 'revista']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResolucion0()
    {
        return $this->hasOne(Resolucion::className(), ['id' => 'resolucion']);
    }

    
}