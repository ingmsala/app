<?php

namespace app\modules\libroclase\models\desarrollo;

use app\modules\libroclase\models\Estadotemaclase;
use app\modules\libroclase\models\Temaunidad;
use Yii;

/**
 * This is the model class for table "detalledesarrollo".
 *
 * @property int $id
 * @property int $temaunidad
 * @property int $estado
 * @property int $desarrollo
 *
 * @property Desarrollo $desarrollo0
 * @property Estadotemaclase $estado0
 * @property Temaunidad $temaunidad0
 */
class Detalledesarrollo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalledesarrollo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['temaunidad', 'estado', 'desarrollo'], 'required'],
            [['temaunidad', 'estado', 'desarrollo'], 'integer'],
            [['desarrollo'], 'exist', 'skipOnError' => true, 'targetClass' => Desarrollo::className(), 'targetAttribute' => ['desarrollo' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadotemaclase::className(), 'targetAttribute' => ['estado' => 'id']],
            [['temaunidad'], 'exist', 'skipOnError' => true, 'targetClass' => Temaunidad::className(), 'targetAttribute' => ['temaunidad' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'temaunidad' => 'Tema de unidad',
            'estado' => 'Estado',
            'desarrollo' => 'Desarrollo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesarrollo0()
    {
        return $this->hasOne(Desarrollo::className(), ['id' => 'desarrollo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estadotemaclase::className(), ['id' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemaunidad0()
    {
        return $this->hasOne(Temaunidad::className(), ['id' => 'temaunidad']);
    }
}
