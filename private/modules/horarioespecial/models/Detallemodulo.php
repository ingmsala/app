<?php

namespace app\modules\horarioespecial\models;

use app\models\Detallecatedra;
use app\models\Espacio;
use Yii;

/**
 * This is the model class for table "detallemodulo".
 *
 * @property int $id
 * @property int $moduloclase
 * @property int $horarioclaseespecial
 * @property int $claseespecial
 * @property int $espacio
 * @property int $grupodivision
 *
 * @property Detallecatedra $claseespecial0
 * @property Moduloclase $moduloclase0
 * @property Horarioclaseespecial $horarioclaseespecial0
 * @property Espacio $espacio0
 * @property Grupodivision $grupodivision0
 */
class Detallemodulo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detallemodulo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['moduloclase', 'grupodivision'], 'required'],
            [['moduloclase', 'horarioclaseespecial', 'detallecatedra', 'espacio', 'grupodivision'], 'integer'],
            [['detallecatedra'], 'exist', 'skipOnError' => true, 'targetClass' => Detallecatedra::className(), 'targetAttribute' => ['detallecatedra' => 'id']],
            [['moduloclase'], 'exist', 'skipOnError' => true, 'targetClass' => Moduloclase::className(), 'targetAttribute' => ['moduloclase' => 'id']],
            [['horarioclaseespecial'], 'exist', 'skipOnError' => true, 'targetClass' => Horarioclaseespecial::className(), 'targetAttribute' => ['horarioclaseespecial' => 'id']],
            [['espacio'], 'exist', 'skipOnError' => true, 'targetClass' => Espacio::className(), 'targetAttribute' => ['espacio' => 'id']],
            [['grupodivision'], 'exist', 'skipOnError' => true, 'targetClass' => Grupodivision::className(), 'targetAttribute' => ['grupodivision' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'moduloclase' => 'Moduloclase',
            'horarioclaseespecial' => 'Horarioclaseespecial',
            'detallecatedra' => 'Detallecatedra',
            'espacio' => 'Espacio',
            'grupodivision' => 'Grupodivision',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallecatedra0()
    {
        return $this->hasOne(Detallecatedra::className(), ['id' => 'detallecatedra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModuloclase0()
    {
        return $this->hasOne(Moduloclase::className(), ['id' => 'moduloclase']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHorarioclaseespecial0()
    {
        return $this->hasOne(Horarioclaseespecial::className(), ['id' => 'horarioclaseespecial']);
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
    public function getGrupodivision0()
    {
        return $this->hasOne(Grupodivision::className(), ['id' => 'grupodivision']);
    }
}
