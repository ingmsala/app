<?php

namespace app\modules\horarioespecial\models;

use app\models\Detallecatedra;
use Yii;

/**
 * This is the model class for table "claseespecial".
 *
 * @property int $id
 * @property int $horarioclaseespecial
 * @property string $fecha
 * @property string $aula
 * @property int $detallecatedra
 *
 * @property Detallecatedra $detallecatedra0
 * @property Horarioclaseespecial $horarioclaseespecial0
 */
class Claseespecial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'claseespecial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['horarioclaseespecial', 'fecha', 'detallecatedra'], 'required'],
            [['horarioclaseespecial', 'detallecatedra'], 'integer'],
            [['fecha'], 'safe'],
            [['aula'], 'string', 'max' => 150],
            [['detallecatedra'], 'exist', 'skipOnError' => true, 'targetClass' => Detallecatedra::className(), 'targetAttribute' => ['detallecatedra' => 'id']],
            [['horarioclaseespecial'], 'exist', 'skipOnError' => true, 'targetClass' => Horarioclaseespecial::className(), 'targetAttribute' => ['horarioclaseespecial' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'horarioclaseespecial' => 'Horarioclaseespecial',
            'fecha' => 'Fecha',
            'aula' => 'Aula',
            'detallecatedra' => 'Detallecatedra',
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
    public function getHorarioclaseespecial0()
    {
        return $this->hasOne(Horarioclaseespecial::className(), ['id' => 'horarioclaseespecial']);
    }
}
