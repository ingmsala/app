<?php

namespace app\modules\mones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mones\models\Monmateria;

/**
 * MonmateriaSearch represents the model behind the search form of `app\modules\mones\models\Monmateria`.
 */
class MonmateriaSearch extends Monmateria
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nombre', 'codmon'], 'safe'],
            [['carrera'], 'integer'],
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
        $query = Monmateria::find();

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
            'carrera' => $this->carrera,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'codmon', $this->codmon]);

        return $dataProvider;
    }
}
