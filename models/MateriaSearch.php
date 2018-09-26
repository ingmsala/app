<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Materia;


/**
 * MateriaSearch represents the model behind the search form of `app\models\Materia`.
 */
class MateriaSearch extends Materia
{
    public $plan;
    public $curso;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cantHoras',], 'integer'],
            [['nombre', 'plan', 'curso'], 'safe'],
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
        $query = Materia::find()->joinWith(['plan0', 'curso0']);
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

        $dataProvider->sort->attributes['plan0'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['plan.nombre' => SORT_ASC],
        'desc' => ['plan.nombre' => SORT_DESC],
        ];
        // Lets do the same with country now
        $dataProvider->sort->attributes['curso0'] = [
        'asc' => ['curso.nombre' => SORT_ASC],
        'desc' => ['curso.nombre' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cantHoras' => $this->cantHoras,
            
        ]);
        $query->andFilterWhere(['like', 'materia.nombre', $this->nombre])
        ->andFilterWhere(['like', 'plan.nombre', $this->plan])
        ->andFilterWhere(['like', 'curso.nombre', $this->curso]);

        return $dataProvider;
    }
}
