<?php

namespace app\modules\edh\models;


use Yii;
use app\models\Trimestral;

/**
 * This is the model class for table "notaedh".
 *
 * @property int $id
 * @property int $nota
 * @property int $tiponota
 * @property int $trimestre
 * @property int $detalleplancursado
 *
 * @property Detalleplancursado $detalleplancursado0
 * @property Tiponotaedh $tiponota0
 * @property Trimestral $trimestre0
 */
class Notaedh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notaedh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nota', 'tiponota', 'trimestre', 'detalleplancursado'], 'required'],
            [['tiponota', 'trimestre', 'detalleplancursado'], 'integer'],
            [['nota'], 'integer', 'min' => 0, 'max' => 10],
            [['detalleplancursado'], 'exist', 'skipOnError' => true, 'targetClass' => Detalleplancursado::className(), 'targetAttribute' => ['detalleplancursado' => 'id']],
            [['tiponota'], 'exist', 'skipOnError' => true, 'targetClass' => Tiponotaedh::className(), 'targetAttribute' => ['tiponota' => 'id']],
            [['trimestre'], 'exist', 'skipOnError' => true, 'targetClass' => Trimestral::className(), 'targetAttribute' => ['trimestre' => 'id']],
            
        ];
    }

    

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nota' => 'Nota',
            'tiponota' => 'Tipo de nota',
            'trimestre' => 'Trimestre',
            'detalleplancursado' => 'Detalle de plan de cursado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleplancursado0()
    {
        return $this->hasOne(Detalleplancursado::className(), ['id' => 'detalleplancursado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiponota0()
    {
        return $this->hasOne(Tiponotaedh::className(), ['id' => 'tiponota']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrimestre0()
    {
        return $this->hasOne(Trimestral::className(), ['id' => 'trimestre']);
    }
}
