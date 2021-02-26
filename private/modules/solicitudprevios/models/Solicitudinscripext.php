<?php

namespace app\modules\solicitudprevios\models;

use app\models\Actividad;
use Yii;
use app\models\Turnoexamen;


/**
 * This is the model class for table "solicitudinscripext".
 *
 * @property int $id
 * @property string $apellido
 * @property string $nombre
 * @property string $documento
 * @property int $turno
 * @property string $fecha
 * @property string $mail
 * @property string $telefono
 *
 * @property Adjuntosolicitudext[] $adjuntosolicitudexts
 * @property Detallesolicitudext[] $detallesolicitudexts
 * @property Turnoexamen $turno0
 */
class Solicitudinscripext extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solicitudinscripext';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido', 'nombre', 'documento', 'turno', 'fecha', 'mail', 'telefono'], 'required'],
            [['turno'], 'integer'],
            [['fecha'], 'safe'],
            [['apellido', 'nombre', 'mail'], 'string', 'max' => 200],
            ['mail', 'email'],
            [['documento'], 'string', 'max' => 8],
            [['telefono'], 'string', 'max' => 150],
            [['turno'], 'exist', 'skipOnError' => true, 'targetClass' => Turnoexamen::className(), 'targetAttribute' => ['turno' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'N° solicitud',
            'apellido' => 'Apellido',
            'nombre' => 'Nombre',
            'documento' => 'Documento',
            'turno' => 'Turno de examen',
            'fecha' => 'Fecha de solicitud',
            'mail' => 'Correo electrónico',
            'telefono' => 'Nro de Teléfono / Celular de contacto',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdjuntosolicitudexts()
    {
        return $this->hasMany(Adjuntosolicitudext::className(), ['solicitud' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallesolicitudexts()
    {
        return $this->hasMany(Detallesolicitudext::className(), ['solicitud' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurno0()
    {
        return $this->hasOne(Turnoexamen::className(), ['id' => 'turno']);
    }

    public function getActividads()
    {
        return $this->hasMany(Actividad::className(), ['id' => 'actividad'])->via('detallesolicitudexts');
    }

}
