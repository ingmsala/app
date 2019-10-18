<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "docente".
 *
 * @property int $id
 * @property string $legajo
 * @property string $apellido
 * @property string $nombre
 * @property int $genero
 *
 * @property Detallecatedra[] $detallecatedras
 * @property Genero $genero0
 * @property Nombramiento[] $nombramientos
 */
class Docente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const SCENARIO_FINDHORARIOLOGIN = 'logindoc';
    const SCENARIO_ABM = 'abmdoc';
   

    

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_FINDHORARIOLOGIN] = ['legajo'];
        $scenarios[self::SCENARIO_ABM] = ['apellido', 'nombre', 'genero','legajo'];
        
        return $scenarios;
    }

    public static function tableName()
    {
        return 'docente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido', 'nombre', 'genero'], 'required', 'on' => self::SCENARIO_ABM],
            [['legajo'], 'required',  'on' => self::SCENARIO_FINDHORARIOLOGIN],
            [['genero'], 'integer'],
            [['legajo'], 'string', 'max' => 8],
            [['apellido', 'nombre'], 'string', 'max' => 70],
            [['legajo'], 'unique', 'on' => self::SCENARIO_ABM],
            [['genero'], 'exist', 'skipOnError' => true, 'targetClass' => Genero::className(), 'targetAttribute' => ['genero' => 'id']],
            [['legajo'], 'findDoc', 'on' => self::SCENARIO_FINDHORARIOLOGIN],
        ];
    }

    public function findDoc($attribute, $params, $validator)
    {
        $doc = Docente::find()
            ->joinWith('detallecatedras')
            ->where(['=', 'detallecatedra.revista', 6])
            ->andWhere(['legajo' => $this->legajo])->all();
        if (count($doc)<1)
            $this->addError($attribute, 'El legajo no corresponde a un docente con un horario activo. Pruebe con su DNI. De persistir el inconveniente consulte en regencia');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'legajo' => 'Legajo',
            'apellido' => 'Apellido',
            'nombre' => 'Nombre',
            'genero' => 'Genero',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallecatedras()
    {
        return $this->hasMany(Detallecatedra::className(), ['docente' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenero0()
    {
        return $this->hasOne(Genero::className(), ['id' => 'genero']);
    }

    public function getCatedras()
    {
        return $this->hasMany(Catedra::className(), ['id' => 'catedra'])->via('detallecatedras');
    }

    public function getCondicions()
    {
        return $this->hasMany(Condicion::className(), ['id' => 'condicion'])->via('detallecatedras');
    }

    public function getNombramientos()
    {
        return $this->hasMany(Nombramiento::className(), ['docente' => 'id']);
    }

    public function getDetallepartes()
    {
        return $this->hasMany(Detalleparte::className(), ['docente' => 'id']);
    }


   
}
