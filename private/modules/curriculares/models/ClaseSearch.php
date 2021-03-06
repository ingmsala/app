<?php

namespace app\modules\curriculares\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\curriculares\models\Clase;
use yii\db\Query;

/**
 * ClaseSearch represents the model behind the search form of `app\modules\optativas\models\Clase`.
 */
class ClaseSearch extends Clase
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipoclase', 'comision', 'horascatedra', 'tipoasistencia'], 'integer'],
            [['fecha', 'tema', 'hora', 'horafin'], 'safe'],
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
    public function search($params, $tipoespacio)
    {
        if($tipoespacio == 1){
            $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        }elseif($tipoespacio == 2){
            $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
        }else{
            $com = '';
        }
        
        $query = Clase::find()
            ->where(['comision' => $com])
            ->orderBy('fecha DESC');

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
            'fecha' => $this->fecha,
            'tipoclase' => $this->tipoclase,
            'comision' => $this->comision,
            'horascatedra' => $this->horascatedra,
        ]);

        $query->andFilterWhere(['like', 'tema', $this->tema]);

        return $dataProvider;
    }

    public function getHorasTotalactual($com){
        $query = new Query();
        $query->from('clase')
            ->where(['comision' => $com]);
        return $query->sum('horascatedra');
    }

    public function getHorasParcialactual($com, $tipo){
        $query = new Query();
        $query->from('clase')
            ->where(['comision' => $com])
            ->andWhere(['tipoclase' => $tipo]);
        return $query->sum('horascatedra');
    }

    public function clasexalumno($params)
    {
        $com = $params['id'];
        $query = Clase::find()
            ->where(['comision' => $com])
            ->orderBy('fecha DESC');

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
            'fecha' => $this->fecha,
            'tipoclase' => $this->tipoclase,
            'comision' => $this->comision,
            'horascatedra' => $this->horascatedra,
        ]);

        $query->andFilterWhere(['like', 'tema', $this->tema]);

        return $dataProvider;
    }


    public function getClasesHoy()
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $query = Clase::find()
            ->where(['fecha' => date('Y-m-d')])
            ->orderBy('hora asc');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       

        return $dataProvider;
    }
}
