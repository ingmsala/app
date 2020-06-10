<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Funciondj;

/**
 * FunciondjSearch represents the model behind the search form of `app\models\Funciondj`.
 */
class FunciondjSearch extends Funciondj
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'horas', 'declaracionjurada'], 'integer'],
            [['reparticion', 'cargo'], 'safe'],
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
    public function search($dj)
    {
        $query = Funciondj::find()->where(['declaracionjurada' => $dj])-> indexBy ( 'id' );

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($dj);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'horas' => $this->horas,
            'declaracionjurada' => $this->declaracionjurada,
        ]);

        $query->andFilterWhere(['like', 'reparticion', $this->reparticion])
            ->andFilterWhere(['like', 'cargo', $this->cargo]);

        return $dataProvider;
    }
}
