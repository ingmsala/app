<?php

namespace app\models;
use app\modules\curriculares\models\Aniolectivo;
use Yii;

/**
 * This is the model class for table "anioxtrimestral".
 *
 * @property int $id
 * @property int $aniolectivo
 * @property int $trimestral
 * @property string $inicio
 * @property string $fin
 * @property int $activo
 * @property int $publicado
 *
 * @property Aniolectivo $aniolectivo0
 * @property Trimestral $trimestral0
 * @property Horarioexamen[] $horarioexamens
 */
class Anioxtrimestral extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anioxtrimestral';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aniolectivo', 'trimestral', 'inicio', 'fin', 'activo', 'publicado'], 'required'],
            [['aniolectivo', 'trimestral', 'activo', 'publicado'], 'integer'],
            [['inicio', 'fin'], 'safe'],
            [['aniolectivo'], 'exist', 'skipOnError' => true, 'targetClass' => Aniolectivo::className(), 'targetAttribute' => ['aniolectivo' => 'id']],
            [['trimestral'], 'exist', 'skipOnError' => true, 'targetClass' => Trimestral::className(), 'targetAttribute' => ['trimestral' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aniolectivo' => 'Año Lectivo',
            'trimestral' => 'Instancia',
            'inicio' => 'Inicio',
            'fin' => 'Fin',
            'activo' => 'Activo',
            'publicado' => 'Publicado',
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
    public function getTrimestral0()
    {
        return $this->hasOne(Trimestral::className(), ['id' => 'trimestral']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHorarioexamens()
    {
        return $this->hasMany(Horarioexamen::className(), ['anioxtrimestral' => 'id']);
    }
}
