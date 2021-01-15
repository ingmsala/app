<?php

namespace app\modules\edh\models;

use Yii;

/**
 * This is the model class for table "caso".
 *
 * @property int $id
 * @property string $inicio
 * @property string $fin
 * @property string $resolucion
 * @property int $matricula
 * @property int $condicionfinal
 * @property int $estadocaso
 *
 * @property Condicionfinal $condicionfinal0
 * @property Estadocaso $estadocaso0
 * @property Matriculaedh $matricula0
 * @property Informeprofesional[] $informeprofesionals
 * @property Solicitudedh[] $solicitudedhs
 */
class Caso extends \yii\db\ActiveRecord
{
    public $aniolectivo;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'caso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inicio', 'matricula', 'condicionfinal', 'estadocaso'], 'required'],
            [['inicio', 'fin'], 'safe'],
            [['matricula', 'condicionfinal', 'estadocaso'], 'integer'],
            [['resolucion'], 'string', 'max' => 150],
            [['condicionfinal'], 'exist', 'skipOnError' => true, 'targetClass' => Condicionfinal::className(), 'targetAttribute' => ['condicionfinal' => 'id']],
            [['estadocaso'], 'exist', 'skipOnError' => true, 'targetClass' => Estadocaso::className(), 'targetAttribute' => ['estadocaso' => 'id']],
            [['matricula'], 'exist', 'skipOnError' => true, 'targetClass' => Matriculaedh::className(), 'targetAttribute' => ['matricula' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inicio' => 'Fecha de solicitud',
            'fin' => 'Fin',
            'resolucion' => 'N° Resolución',
            'matricula' => 'Estudiante',
            'condicionfinal' => 'Condicionfinal',
            'estadocaso' => 'Estadocaso',
            'aniolectivo' => 'Año lectivo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCondicionfinal0()
    {
        return $this->hasOne(Condicionfinal::className(), ['id' => 'condicionfinal']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadocaso0()
    {
        return $this->hasOne(Estadocaso::className(), ['id' => 'estadocaso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatricula0()
    {
        return $this->hasOne(Matriculaedh::className(), ['id' => 'matricula']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformeprofesionals()
    {
        return $this->hasMany(Informeprofesional::className(), ['caso' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudedhs()
    {
        return $this->hasMany(Solicitudedh::className(), ['caso' => 'id']);
    }
}
