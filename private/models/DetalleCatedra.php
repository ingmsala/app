<?php

namespace app\models;

use app\modules\curriculares\models\Aniolectivo;
use Yii;

/**
 * This is the model class for table "detallecatedra".
 *
 * @property int $id
 * @property int $docente
 * @property int $catedra
 * @property int $condicion
 * @property int $revista
 * @property int $hora
 * @property int $resolucion
 * @property string $fechaInicio
 * @property string $fechaFin
 * @property int $activo
 *
 * @property Agente $agente0
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
            [['agente', 'catedra', 'condicion', 'revista', 'hora'], 'required'],
            [['agente', 'catedra', 'condicion', 'revista', 'hora', 'aniolectivo'], 'integer'],
            [['fechaInicio', 'fechaFin', 'resolucion'], 'safe'],
            /*['hora', 'compare', 'compareValue' => Catedra::findOne($_REQUEST['catedra'])->actividad0->cantHoras, 'operator' => '<=', 'type' => 'number'],*/
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['catedra'], 'exist', 'skipOnError' => true, 'targetClass' => Catedra::className(), 'targetAttribute' => ['catedra' => 'id']],
            [['condicion'], 'exist', 'skipOnError' => true, 'targetClass' => Condicion::className(), 'targetAttribute' => ['condicion' => 'id']],
            [['revista'], 'exist', 'skipOnError' => true, 'targetClass' => Revista::className(), 'targetAttribute' => ['revista' => 'id']],
            [['aniolectivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aniolectivo::className(), 'targetAttribute' => ['aniolectivo' => 'id']],
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
            'catedra' => 'Catedra',
            'condicion' => 'Condicion',
            'revista' => 'Revista',
            'hora' => 'Horas',
            'resolucion' => 'Resolucion',
            'fechaInicio' => 'Fecha Inicio',
            'fechaFin' => 'Fecha Fin',
            'aniolectivo' => 'Año lectivo',
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

    public function getAniolectivo0()
    {
        return $this->hasOne(Aniolectivo::className(), ['id' => 'aniolectivo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    

    
}
