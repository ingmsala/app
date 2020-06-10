<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pasividaddj;

/**
 * PasividaddjSearch represents the model behind the search form of `app\models\Pasividaddj`.
 */
class PasividaddjSearch extends Pasividaddj
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'percibe', 'declaracionjurada'], 'integer'],
            [['regimen', 'causa', 'caja', 'fecha'], 'safe'],
            [['importe'], 'number'],
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
        $query = Pasividaddj::find();

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
            'importe' => $this->importe,
            'percibe' => $this->percibe,
            'declaracionjurada' => $this->declaracionjurada,
        ]);

        $query->andFilterWhere(['like', 'regimen', $this->regimen])
            ->andFilterWhere(['like', 'causa', $this->causa])
            ->andFilterWhere(['like', 'caja', $this->caja]);

        return $dataProvider;
    }
}
