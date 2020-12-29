<?php

namespace app\modules\curriculares\models;
use app\models\Agente;
use app\models\Role;

use Yii;

/**
 * This is the model class for table "docentexcomision".
 *
 * @property int $id
 * @property int $docente
 * @property int $comision
 *
 * @property Comision $comision0
 * @property Agente $agente0
 */
class Docentexcomision extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'docentexcomision';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agente', 'comision', 'role'], 'required'],
            [['agente', 'comision', 'role'], 'integer'],
            [['comision'], 'exist', 'skipOnError' => true, 'targetClass' => Comision::className(), 'targetAttribute' => ['comision' => 'id']],
            [['agente'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['agente' => 'id']],
            [['role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agente' => 'Agente',
            'comision' => 'Comision',
            'role' => 'Rol',
        ];
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
    public function getAgente0()
    {
        return $this->hasOne(Agente::className(), ['id' => 'agente']);
    }

    public function getRole0()
    {
        return $this->hasOne(Role::className(), ['id' => 'role']);
    }
}
