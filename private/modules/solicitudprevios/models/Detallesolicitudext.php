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
            [['actividad', 'solicitud', 'estado'], 'integer'],
            [['actividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::className(), 'targetAttribute' => ['actividad' => 'id']],
            [['solicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitudinscripext::className(), 'targetAttribute' => ['solicitud' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoxsolicitudext::className(), 'targetAttribute' => ['estado' => 'id']],
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
            'estado' => 'Estado',
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

    public function getEstado0()
    {
        return $this->hasOne(Estadoxsolicitudext::className(), ['id' => 'estado']);
    }
}
