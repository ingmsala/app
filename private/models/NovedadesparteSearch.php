<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Novedadesparte;

/**
 * NovedadesparteSearch represents the model behind the search form of `app\models\Novedadesparte`.
 */
class NovedadesparteSearch extends Novedadesparte
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tiponovedad', 'parte', 'estadonovedad', 'docente'], 'integer'],
            [['descripcion'], 'safe'],
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
        $query = Novedadesparte::find();

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
            'tiponovedad' => $this->tiponovedad,
            'parte' => $this->parte,
            'estadonovedad' => $this->estadonovedad,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    public function novedadesxparte($id)
    {
        $query = Novedadesparte::find()
                    ->joinWith(['tiponovedad0'])
                    ->where(['parte' => $id])
                    ->orderBy('tiponovedad.id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($id);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tiponovedad' => $this->tiponovedad,
            'parte' => $this->parte,
            'estadonovedad' => $this->estadonovedad,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    public function novedadesactivas()
    {
        $query = Novedadesparte::find()
                    ->joinWith(['tiponovedad0', 'parte0'])
                    ->where(['estadonovedad' => 1])
                    ->andWhere(['<>', 'tiponovedad', 1])
                    ->andWhere(['<>', 'tiponovedad', 5])
                    ->orderBy('parte.fecha');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tiponovedad' => $this->tiponovedad,
            'parte' => $this->parte,
            'estadonovedad' => $this->estadonovedad,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

     public function novedadesactivascant()
    {
        $query = Novedadesparte::find()
                    ->where(['estadonovedad' => 1])
                    ->andWhere(['<>', 'tiponovedad', 1])
                    ->andWhere(['<>', 'tiponovedad', 5])
                    ->count();
        return $query;
    }
}
