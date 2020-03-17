<?php

namespace app\modules\curriculares\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "acta".
 *
 * @property int $id
 * @property string $nombre
 * @property int $libro
 * @property int $rectifica
 * @property int $comision
 * @property int $estadoacta
 * @property int $user
 * @property string $fecha
 * @property int $escalanota
 *
 * @property Libroacta $libro0
 * @property Comision $comision0
 * @property Estadoacta $estadoacta0
 * @property User $user0
 * @property Escalanota $escalanota0
 * @property Acta $rectifica0
 * @property Acta[] $actas
 * @property Detalleacta[] $detalleactas
 */
class Acta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const SCENARIO_ABM = 'abmacta';

     public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ABM] = ['fecha', 'escalanota'];
        
        return $scenarios;
    }


    public static function tableName()
    {
        return 'acta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'escalanota'], 'required', 'on' => self::SCENARIO_ABM],
            [['libro', 'rectifica', 'comision', 'estadoacta', 'user', 'escalanota'], 'integer'],
            [['fecha'], 'safe'],
            [['nombre'], 'string', 'max' => 10],
            [['libro'], 'exist', 'skipOnError' => true, 'targetClass' => Libroacta::className(), 'targetAttribute' => ['libro' => 'id']],
            [['comision'], 'exist', 'skipOnError' => true, 'targetClass' => Comision::className(), 'targetAttribute' => ['comision' => 'id']],
            [['estadoacta'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoacta::className(), 'targetAttribute' => ['estadoacta' => 'id']],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
            [['escalanota'], 'exist', 'skipOnError' => true, 'targetClass' => Escalanota::className(), 'targetAttribute' => ['escalanota' => 'id']],
            [['rectifica'], 'exist', 'skipOnError' => true, 'targetClass' => Acta::className(), 'targetAttribute' => ['rectifica' => 'id']],
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
            'libro' => 'Libro',
            'rectifica' => 'Rectifica',
            'comision' => 'Comision',
            'estadoacta' => 'Estadoacta',
            'user' => 'User',
            'fecha' => 'Fecha',
            'escalanota' => 'Escalanota',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibro0()
    {
        return $this->hasOne(Libroacta::className(), ['id' => 'libro']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComision0()
    {
        return $this->hasOne(Comision::className(), ['id' => 'comision']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoacta0()
    {
        return $this->hasOne(Estadoacta::className(), ['id' => 'estadoacta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEscalanota0()
    {
        return $this->hasOne(Escalanota::className(), ['id' => 'escalanota']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRectifica0()
    {
        return $this->hasOne(Acta::className(), ['id' => 'rectifica']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActas()
    {
        return $this->hasMany(Acta::className(), ['rectifica' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleactas()
    {
        return $this->hasMany(Detalleacta::className(), ['acta' => 'id']);
    }
}
