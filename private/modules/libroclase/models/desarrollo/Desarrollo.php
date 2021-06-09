<?php

namespace app\modules\libroclase\models\desarrollo;

use app\models\Agente;
use app\models\Catedra;
use app\modules\curriculares\models\Aniolectivo;
use Yii;

/**
 * This is the model class for table "desarrollo".
 *
 * @property int $id
 * @property int $aniolectivo
 * @property int $catedra
 * @property int $docente
 * @property int $estado
 * @property string $fechacreacion
 * @property string $fechaenvio
 * @property string $motivo
 *
 * @property Aniolectivo $aniolectivo0
 * @property Catedra $catedra0
 * @property Agente $docente0
 * @property Desarrolloestado $estado0
 * @property Detalledesarrollo[] $detalledesarrollos
 */
class Desarrollo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'desarrollo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aniolectivo', 'catedra', 'docente', 'estado', 'fechacreacion', 'token'], 'required'],
            [['aniolectivo', 'catedra', 'docente', 'estado'], 'integer'],
            [['fechacreacion', 'fechaenvio'], 'safe'],
            [['motivo', 'token'], 'string'],
            [['aniolectivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aniolectivo::className(), 'targetAttribute' => ['aniolectivo' => 'id']],
            [['catedra'], 'exist', 'skipOnError' => true, 'targetClass' => Catedra::className(), 'targetAttribute' => ['catedra' => 'id']],
            [['docente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['docente' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Desarrolloestado::className(), 'targetAttribute' => ['estado' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aniolectivo' => 'Año lectivo',
            'catedra' => 'Cátedra',
            'docente' => 'Docente',
            'estado' => 'Estado',
            'fechacreacion' => 'Fecha de creación',
            'fechaenvio' => 'Fecha de envío',
            'motivo' => 'Motivos por los que no se dictaron los temas',
            'token' => 'Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAniolectivo0()
    {
        return $this->hasOne(Aniolectivo::className(), ['id' => 'aniolectivo']);
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
    public function getDocente0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'docente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Desarrolloestado::className(), ['id' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalledesarrollos()
    {
        return $this->hasMany(Detalledesarrollo::className(), ['desarrollo' => 'id']);
    }
}
