<?php

namespace app\modules\libroclase\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\libroclase\models\Temaxclase;

/**
 * TemaxclaseSearch represents the model behind the search form of `app\modules\libroclase\models\Temaxclase`.
 */
class TemaxclaseSearch extends Temaxclase
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'clasediaria', 'temaunidad', 'tipodesarrollo'], 'integer'],
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
        $query = Temaxclase::find();

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
            'clasediaria' => $this->clasediaria,
            'temaunidad' => $this->temaunidad,
            'tipodesarrollo' => $this->tipodesarrollo,
        ]);

        return $dataProvider;
    }
}
