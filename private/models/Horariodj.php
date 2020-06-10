<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "horariodj".
 *
 * @property int $id
 * @property int $diasemana
 * @property string $inicio
 * @property string $fin
 * @property int $funciondj
 * @property int $actividadnooficial
 *
 * @property Actividadnooficial $actividadnooficial0
 * @property Diasemana $diasemana0
 * @property Funciondj $funciondj0
 */
class Horariodj extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horariodj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['diasemana', 'inicio', 'fin'], 'required'],
            [['diasemana', 'funciondj', 'actividadnooficial'], 'integer'],
            [['inicio', 'fin'], 'safe'],
            [['fin'], 'mayores'],
            [['inicio'], 'formato1'],
            [['fin'], 'formato2'],
            [['actividadnooficial'], 'exist', 'skipOnError' => true, 'targetClass' => Actividadnooficial::className(), 'targetAttribute' => ['actividadnooficial' => 'id']],
            [['diasemana'], 'exist', 'skipOnError' => true, 'targetClass' => Diasemana::className(), 'targetAttribute' => ['diasemana' => 'id']],
            [['funciondj'], 'exist', 'skipOnError' => true, 'targetClass' => Funciondj::className(), 'targetAttribute' => ['funciondj' => 'id']],
        ];
    }

    public function mayores($attribute, $params, $validator)
    {
        
            if($this->inicio >= $this->fin)
                $this->addError($attribute, 'La hora de finalización debe ser posterior a la de inicio');
    }

    public function formato1($attribute, $params, $validator)
    {
        if (preg_match('/^\d{2}:\d{2}$/', $this->inicio)) {
            if (preg_match("/(2[0-3]|[0][0-9]|1[0-9]):([0-5][0-9])/", $this->inicio)) {
                $checked = true;
            }else{
                $this->addError($attribute, 'Ingresar un formato de hora correcto. Por ejemplo 20:50');
            }
        }
    }
    public function formato2($attribute, $params, $validator)
    {
        if (preg_match('/^\d{2}:\d{2}$/', $this->fin)) {
            if (preg_match("/(2[0-3]|[0][0-9]|1[0-9]):([0-5][0-9])/", $this->fin)) {
                $checked = true;
            }else{
                $this->addError($attribute, 'Ingresar un formato de hora correcto. Por ejemplo 20:50');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'diasemana' => 'Diasemana',
            'inicio' => 'Hora desde',
            'fin' => 'Hora hasta',
            'funciondj' => 'Funciondj',
            'actividadnooficial' => 'Actividadnooficial',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividadnooficial0()
    {
        return $this->hasOne(Actividadnooficial::className(), ['id' => 'actividadnooficial']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiasemana0()
    {
        return $this->hasOne(Diasemana::className(), ['id' => 'diasemana']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunciondj0()
    {
        return $this->hasOne(Funciondj::className(), ['id' => 'funciondj']);
    }
}
