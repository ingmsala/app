<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mesaexamen".
 *
 * @property int $id
 * @property int $nombre
 * @property string $fecha
 * @property string $hora
 * @property int $turnoexamen
 * @property int $espacio
 *
 * @property Turnoexamen $turnoexamen0
 * @property Espacio $espacio0
 * @property Tribunal[] $tribunals
 */
class Mesaexamen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mesaexamen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['turnoexamen', 'espacio'], 'integer'],
            [['fecha', 'hora', 'turnoexamen'], 'required'],
            [['nombre', 'fecha', 'hora'], 'safe'],
            [['turnoexamen'], 'exist', 'skipOnError' => true, 'targetClass' => Turnoexamen::className(), 'targetAttribute' => ['turnoexamen' => 'id']],
            [['espacio'], 'exist', 'skipOnError' => true, 'targetClass' => Espacio::className(), 'targetAttribute' => ['espacio' => 'id']],
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
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'turnoexamen' => 'Turno de examen',
            'espacio' => 'Espacio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurnoexamen0()
    {
        return $this->hasOne(Turnoexamen::className(), ['id' => 'turnoexamen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspacio0()
    {
        return $this->hasOne(Espacio::className(), ['id' => 'espacio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTribunals()
    {
        return $this->hasMany(Tribunal::className(), ['mesaexamen' => 'id']);
    }
}
