<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Actividadnooficial;

/**
 * ActividadnooficialSearch represents the model behind the search form of `app\models\Actividadnooficial`.
 */
class ActividadnooficialSearch extends Actividadnooficial
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'declaracionjurada'], 'integer'],
            [['empleador', 'lugar', 'ingreso', 'funcion'], 'safe'],
            [['sueldo'], 'number'],
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
        $query = Actividadnooficial::find();

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
            'sueldo' => $this->sueldo,
            'ingreso' => $this->ingreso,
            'declaracionjurada' => $this->declaracionjurada,
        ]);

        $query->andFilterWhere(['like', 'empleador', $this->empleador])
            ->andFilterWhere(['like', 'lugar', $this->lugar])
            ->andFilterWhere(['like', 'funcion', $this->funcion]);

        return $dataProvider;
    }
}
