<?php

namespace app\modules\horariogenerico\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\horariogenerico\models\Horariogeneric;
use yii\data\SqlDataProvider;

/**
 * HorariogenericSearch represents the model behind the search form of `app\modules\horariogenerico\models\Horariogeneric`.
 */
class HorariogenericSearch extends Horariogeneric
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'catedra', 'horareloj', 'semana', 'burbuja', 'aniolectivo', 'diasemana'], 'integer'],
            [['fecha'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Horariogeneric::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'catedra' => $this->catedra,
            'horareloj' => $this->horareloj,
            'semana' => $this->semana,
            'fecha' => $this->fecha,
            'burbuja' => $this->burbuja,
            'aniolectivo' => $this->aniolectivo,
            'diasemana' => $this->diasemana,
        ]);

        return $dataProvider;
    }

    public function reporteporsemana($semana)
    {
        $query = Horariogeneric::find()
            ->select('catedra.division as divid,  horariogeneric.semana, division.nombre as division, horariogeneric.fecha, diasemana.nombre as diasemananombre, burbuja.nombre as burbujanombre, count(horariogeneric.id) as cant')
            ->joinWith(['catedra0','catedra0.division0', 'horareloj0', 'burbuja0', 'diasemana0'])
            ->where(['horariogeneric.semana' => $semana])
            ->groupBy('horariogeneric.semana, divid, division, horariogeneric.fecha, burbujanombre', 'diasemananombre')
            ->orderBy('division.nombre, horariogeneric.diasemana, horareloj.hora');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($semana);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'catedra' => $this->catedra,
            'horareloj' => $this->horareloj,
            'semana' => $this->semana,
            'fecha' => $this->fecha,
            'burbuja' => $this->burbuja,
            'aniolectivo' => $this->aniolectivo,
            'diasemana' => $this->diasemana,
        ]);

        return $dataProvider;
    }

    public function horassuperpuestas()
    {
        $sql='
            SELECT
                `agente`.`id`,
                `agente`.`apellido`,
                `agente`.`nombre`,
                `horariogeneric`.`fecha`,
                `horareloj`.`hora`,
                `division`.`turno`,
                COUNT(horariogeneric.id)
            FROM
                `horariogeneric`
            LEFT JOIN `catedra` ON `horariogeneric`.`catedra` = `catedra`.`id`
            LEFT JOIN `detallecatedra` ON `catedra`.`id` = `detallecatedra`.`catedra`
            LEFT JOIN `agente` ON `detallecatedra`.`agente` = `agente`.`id`
            LEFT JOIN `division` ON `catedra`.`division` = `division`.`id`
            LEFT JOIN `horareloj` ON `horariogeneric`.`horareloj` = `horareloj`.`id`
            WHERE
                `detallecatedra`.`revista` = 6 AND
                `detallecatedra`.`aniolectivo` = 3 AND
                `horariogeneric`.`aniolectivo` = 3 
            GROUP BY
                `agente`.`id`,
                `agente`.`apellido`,
                `agente`.`nombre`,
                `horariogeneric`.`fecha`,
                `horareloj`.`hora`,
                `division`.`turno`
            HAVING
                COUNT(horariogeneric.id) > 1
            ORDER BY
                `agente`.`apellido`,
                `agente`.`nombre`';


        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
            
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        
        // grid filtering conditions
        

        return $dataProvider;
    }
}
