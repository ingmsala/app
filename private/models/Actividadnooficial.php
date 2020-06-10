<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividadnooficial".
 *
 * @property int $id
 * @property string $empleador
 * @property string $lugar
 * @property double $sueldo
 * @property string $ingreso
 * @property string $funcion
 * @property int $declaracionjurada
 *
 * @property Declaracionjurada $declaracionjurada0
 * @property Horariodj[] $horariodjs
 */
class Actividadnooficial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actividadnooficial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sueldo'], 'number'],
            [['ingreso'], 'safe'],
            [['declaracionjurada', 'sueldo', 'empleador', 'lugar', 'funcion', 'ingreso'], 'required'],
            [['declaracionjurada'], 'integer'],
            [['empleador', 'lugar', 'funcion'], 'string', 'max' => 250],
            [['declaracionjurada'], 'exist', 'skipOnError' => true, 'targetClass' => Declaracionjurada::className(), 'targetAttribute' => ['declaracionjurada' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empleador' => 'Empleador',
            'lugar' => 'Lugar',
            'sueldo' => 'Sueldo',
            'ingreso' => 'Ingreso',
            'funcion' => 'Función',
            'declaracionjurada' => 'Declaración jurada',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeclaracionjurada0()
    {
        return $this->hasOne(Declaracionjurada::className(), ['id' => 'declaracionjurada']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHorariodjs()
    {
        return $this->hasMany(Horariodj::className(), ['actividadnooficial' => 'id']);
    }
}
