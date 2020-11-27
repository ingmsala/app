<?php

namespace app\modules\mones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mones\models\Monalumno;

/**
 * MonalumnoSearch represents the model behind the search form of `app\modules\mones\models\Monalumno`.
 */
class MonalumnoSearch extends Monalumno
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['documento', 'legajo'], 'integer'],
            [['apellido', 'nombre', 'fechanac'], 'safe'],
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
        $query = Monalumno::find();

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
            'documento' => $this->documento,
            'legajo' => $this->legajo,
            'fechanac' => $this->fechanac,
        ]);

        $query->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
