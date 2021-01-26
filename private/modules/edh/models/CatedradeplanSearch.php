<?php

namespace app\modules\edh\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edh\models\Catedradeplan;

/**
 * CatedradeplanSearch represents the model behind the search form of `app\modules\edh\models\Catedradeplan`.
 */
class CatedradeplanSearch extends Catedradeplan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'catedra', 'plan'], 'integer'],
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
        $query = Catedradeplan::find();

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
            'plan' => $this->plan,
        ]);

        return $dataProvider;
    }
}
