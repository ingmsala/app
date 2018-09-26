<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DetalleCatedra;

/**
 * DetalleCatedraSearch represents the model behind the search form of `app\models\DetalleCatedra`.
 */
class DetalleCatedraSearch extends DetalleCatedra
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'catedra', 'condicion', 'revista', 'resolucion'], 'integer'],
            [['docente', 'fechaInicio', 'fechaFin'], 'safe'],
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
        $query = DetalleCatedra::find();

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
            'condicion' => $this->condicion,
            'revista' => $this->revista,
            'resolucion' => $this->resolucion,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
        ]);

        $query->andFilterWhere(['like', 'docente', $this->docente]);

        return $dataProvider;
    }

    public function providerxcatedra($id)
    {
        $query = DetalleCatedra::find()
            ->where(['catedra' => $id,
                //'condicion' => 5 //suplente
            ])
            ->orderBy('condicion ASC', 'id ASC');

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
