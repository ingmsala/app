<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividadxmesa".
 *
 * @property int $id
 * @property int $actividad
 * @property int $mesaexamen
 *
 * @property Actividad $actividad0
 * @property Mesaexamen $mesaexamen0
 */
class Actividadxmesa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actividadxmesa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actividad', 'mesaexamen'], 'required'],
            [['actividad', 'mesaexamen'], 'integer'],
            [['actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::className(), 'targetAttribute' => ['actividad' => 'id']],
            [['mesaexamen'], 'exist', 'skipOnError' => true, 'targetClass' => Mesaexamen::className(), 'targetAttribute' => ['mesaexamen' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'actividad' => 'Actividad',
            'mesaexamen' => 'Mesaexamen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividad0()
    {
        return $this->hasOne(Actividad::className(), ['id' => 'actividad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMesaexamen0()
    {
        return $this->hasOne(Mesaexamen::className(), ['id' => 'mesaexamen']);
    }
}
