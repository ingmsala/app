<?php

namespace app\modules\curriculares\models;
use app\models\Docente;
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
 * @property Docente $docente0
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
            [['docente', 'comision', 'role'], 'required'],
            [['docente', 'comision', 'role'], 'integer'],
            [['comision'], 'exist', 'skipOnError' => true, 'targetClass' => Comision::className(), 'targetAttribute' => ['comision' => 'id']],
            [['docente'], 'exist', 'skipOnError' => true, 'targetClass' => Docente::className(), 'targetAttribute' => ['docente' => 'id']],
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
            'docente' => 'Docente',
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
    public function getDocente0()
    {
        return $this->hasOne(Docente::className(), ['id' => 'docente']);
    }

    public function getRole0()
    {
        return $this->hasOne(Role::className(), ['id' => 'role']);
    }
}
