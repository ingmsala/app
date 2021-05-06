<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Horariogym;

/**
 * HorariogymSearch represents the model behind the search form of `app\models\Horariogym`.
 */
class HorariogymSearch extends Horariogym
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'division', 'diasemana', 'repite', 'burbuja'], 'integer'],
            [['horario', 'docentes'], 'safe'],
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
        $query = Horariogym::find()
                    ->joinWith(['division0'])
                    ->orderBy('division.turno DESC, horariogym.diasemana, horariogym.horario, division.nombre');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
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
            'division' => $this->division,
            'diasemana' => $this->diasemana,
            'repite' => $this->repite,
            'burbuja' => $this->burbuja,
        ]);

        $query->andFilterWhere(['like', 'horario', $this->horario])
            ->andFilterWhere(['like', 'docentes', $this->docentes]);

        return $dataProvider;
    }

    public function xdivision($division)
    {
        $query = Horariogym::find()
                        ->where(['division' => $division]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($division);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'division' => $this->division,
            'diasemana' => $this->diasemana,
            'repite' => $this->repite,
            'burbuja' => $this->burbuja,
        ]);

        $query->andFilterWhere(['like', 'horario', $this->horario])
            ->andFilterWhere(['like', 'docentes', $this->docentes]);

        return $dataProvider;
    }
}
