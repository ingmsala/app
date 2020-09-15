<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Divisionxmesa;

/**
 * DivisionxmesaSearch represents the model behind the search form of `app\models\Divisionxmesa`.
 */
class DivisionxmesaSearch extends Divisionxmesa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'mesaexamen', 'division'], 'integer'],
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
        $query = Divisionxmesa::find();

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
            'mesaexamen' => $this->mesaexamen,
            'division' => $this->division,
        ]);

        return $dataProvider;
    }
}
