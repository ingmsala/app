<?php

namespace app\modules\horarioespecial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\horarioespecial\models\Horarioclaseespecial;

/**
 * HorarioclaseespecialSearch represents the model behind the search form of `app\modules\horarioespecial\models\Horarioclaseespecial`.
 */
class HorarioclaseespecialSearch extends Horarioclaseespecial
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['inicio', 'fin', 'codigo'], 'safe'],
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
        $query = Horarioclaseespecial::find();

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
        ]);

        return $dataProvider;
    }
}
