<?php

namespace app\modules\sociocomunitarios\models;

use app\modules\curriculares\models\Seguimiento;
use Yii;

/**
 * This is the model class for table "detallerubrica".
 *
 * @property int $id
 * @property int $seguimiento
 * @property int $calificacionrubrica
 * @property int $rubrica
 *
 * @property Rubrica $rubrica0
 * @property Seguimiento $seguimiento0
 */
class Detallerubrica extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detallerubrica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seguimiento', 'calificacionrubrica'], 'required'],
            [['seguimiento', 'calificacionrubrica'], 'integer'],
            [['seguimiento'], 'exist', 'skipOnError' => true, 'targetClass' => Seguimiento::className(), 'targetAttribute' => ['seguimiento' => 'id']],
            [['calificacionrubrica'], 'exist', 'skipOnError' => true, 'targetClass' => Calificacionrubrica::className(), 'targetAttribute' => ['calificacionrubrica' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'seguimiento' => 'Seguimiento',
            'calificacionrubrica' => 'Calificacionrubrica',
            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeguimiento0()
    {
        return $this->hasOne(Seguimiento::className(), ['id' => 'seguimiento']);
    }
    public function getCalificacionrubrica0()
    {
        return $this->hasOne(Calificacionrubrica::className(), ['id' => 'calificacionrubrica']);
    }
}
