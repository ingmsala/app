<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nodocente;

/**
 * NodocenteSearch represents the model behind the search form of `app\models\Nodocente`.
 */
class NodocenteSearch extends Nodocente
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'genero'], 'integer'],
            [['legajo', 'apellido', 'nombre', 'documento'], 'safe'],
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
        $query = Nodocente::find();

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
            'genero' => $this->genero,
        ]);

        $query->andFilterWhere(['like', 'legajo', $this->legajo])
            ->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'documento', $this->documento]);

        return $dataProvider;
    }
}
