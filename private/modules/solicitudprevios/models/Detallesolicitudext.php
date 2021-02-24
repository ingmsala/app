<?php

namespace app\modules\solicitudprevios\models;

use app\models\Actividad;
use Yii;

/**
 * This is the model class for table "detallesolicitudext".
 *
 * @property int $id
 * @property int $actividad
 * @property int $solicitud
 *
 * @property Actividad $actividad0
 * @property Solicitudinscripext $solicitud0
 */
class Detallesolicitudext extends \yii\db\ActiveRecord
{
    public $cant;
    public $materia;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detallesolicitudext';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actividad', 'solicitud'], 'required'],
            [['actividad', 'solicitud'], 'integer'],
            [['actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::className(), 'targetAttribute' => ['actividad' => 'id']],
            [['solicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitudinscripext::className(), 'targetAttribute' => ['solicitud' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'actividad' => 'Materias a rendir',
            'solicitud' => 'Solicitud',
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
    public function getSolicitud0()
    {
        return $this->hasOne(Solicitudinscripext::className(), ['id' => 'solicitud']);
    }
}
