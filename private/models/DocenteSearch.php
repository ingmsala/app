<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Docente;

/**
 * DocenteSearch represents the model behind the search form of `app\models\Docente`.
 */
class DocenteSearch extends Docente
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', ], 'integer'],
            [['legajo', 'apellido', 'nombre', 'genero'], 'safe'],
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
        $query = Docente::find()
            ->joinWith(['genero0'])
            ->orderBy('apellido', 'nombre', 'legajo');

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

        $dataProvider->sort->attributes['genero0'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['genero.nombre' => SORT_ASC],
        'desc' => ['genero.nombre' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            
        ]);

        $query->andFilterWhere(['like', 'legajo', $this->legajo])
            ->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'genero.nombre', $this->genero]);

        return $dataProvider;
    }


    public function detallehoras($id)
    {
        $query = Docente::find()
            ->where(['id' => $id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($id);

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
            ->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
