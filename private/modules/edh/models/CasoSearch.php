<?php

namespace app\modules\edh\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edh\models\Caso;
use yii\data\SqlDataProvider;

/**
 * CasoSearch represents the model behind the search form of `app\modules\edh\models\Caso`.
 */
class CasoSearch extends Caso
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'matricula', 'condicionfinal', 'estadocaso'], 'integer'],
            [['inicio', 'fin', 'resolucion'], 'safe'],
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
        $sql='
        select c.id as id, c.inicio as inicio, c.fin as fin, c.resolucion as resolucion, concat(alu.apellido,", ",alu.nombre) as alumno, cond.nombre as condicionfinal, est.nombre as estadocaso, anio.nombre as aniolectivo
        from caso c
        left join matriculaedh mat ON c.matricula = mat.id
        left join alumno alu ON alu.id = mat.alumno
        left join aniolectivo anio ON mat.aniolectivo = anio.id
        left join condicionfinal cond ON c.condicionfinal = cond.id
        left join estadocaso est ON c.estadocaso = est.id
        where true ';
        if (isset($params['Caso']['aniolectivo']) && $params['Caso']['aniolectivo'] != ''){
            $sql .= ' AND mat.aniolectivo = '.$params['Caso']['aniolectivo'];
        }
        if (isset($params['Caso']['alumno']) && $params['Caso']['alumno'] != ''){
            $sql .= ' AND mat.alumno = '.$params['Caso']['alumno'];
        }
        if (isset($params['Caso']['estadocaso']) && $params['Caso']['estadocaso'] != ''){
            $sql .= ' AND c.estadocaso = '.$params['Caso']['estadocaso'];
        }
        if (isset($params['Caso']['condicionfinal'])){
            $sql .= ' AND c.condicionfinal = '.$params['Caso']['condicionfinal'];
        }
        $sql.= ' order by alu.apellido, alu.nombre';

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
        
        $query = Caso::find();

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
            'inicio' => $this->inicio,
            'fin' => $this->fin,
            'matricula' => $this->matricula,
            'condicionfinal' => $this->condicionfinal,
            'estadocaso' => $this->estadocaso,
        ]);

        $query->andFilterWhere(['like', 'resolucion', $this->resolucion]);

        return $dataProvider;
    }
}
