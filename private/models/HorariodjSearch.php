<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Horariodj;

/**
 * HorariodjSearch represents the model behind the search form of `app\models\Horariodj`.
 */
class HorariodjSearch extends Horariodj
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'diasemana', 'funciondj', 'actividadnooficial'], 'integer'],
            [['inicio', 'fin'], 'safe'],
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
        $query = Horariodj::find();

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
            'diasemana' => $this->diasemana,
            'inicio' => $this->inicio,
            'fin' => $this->fin,
            'funciondj' => $this->funciondj,
            'actividadnooficial' => $this->actividadnooficial,
        ]);

        return $dataProvider;
    }
}
