<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preinscripcion".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $activo
 * @property string $inicio
 * @property string $fin
 */
class Preinscripcion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'preinscripcion';
    }

 
   /* public function beforeSave($insert) {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        
        $explode = explode(' ', $this->inicio);
        $date =   $explode[0];
        $date = explode('/',$date);
        $time = $explode[1];
        $date = $date[2].'-'.$date[1].'-'.$date[0];
        //$date = date("Y-m-d", mktime(0, 0, 0, $date[1], $date[0], $date[2]));
        $this->inicio=$date.' '.$time;
        //$this->fin=Yii::$app->formatter->asDatetime($this->fin);
        //date_default_timezone_set('America/Argentina/Buenos_Aires');
        $explode2 = explode(' ', $this->fin);
        $date2 =   $explode2[0];
        $date2 = explode('/',$date2);
        $time2 = $explode2[1];
        $date2 = $date2[2].'-'.$date2[1].'-'.$date2[0];
        //$date2 = date("Y-m-d", mktime(0, 0, 0, $date2[1], $date2[0], $date2[2]));
        $this->fin=$date2.' '.$time2;
        
        return parent::beforeSave($insert);
    }*/

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'activo'], 'required'],
            [['activo'], 'integer'],
            [['inicio', 'fin'], 'safe'],
            [['descripcion'], 'string', 'max' => 50],
            [['tipoespacio'], 'exist', 'skipOnError' => true, 'targetClass' => Actividadtipo::className(), 'targetAttribute' => ['tipoespacio' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripción',
            'activo' => 'Activo',
            'inicio' => 'Inicio',
            'fin' => 'Fin',
            'tipoespacio' => 'Tipo de actividad',
        ];
    }

    public function getTipoespacio0()
    {
        return $this->hasOne(Actividadtipo::className(), ['id' => 'tipoespacio']);
    }

    public function getAnios()
    {
        return $this->hasMany(Preinscripcionxanio::className(), ['preinscripcion' => 'id']);
    }

}
