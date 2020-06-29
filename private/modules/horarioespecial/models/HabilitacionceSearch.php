<?php

namespace app\modules\horarioespecial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\horarioespecial\models\Habilitacionce;

/**
 * HabilitacionceSearch represents the model behind the search form of `app\modules\horarioespecial\models\Habilitacionce`.
 */
class HabilitacionceSearch extends Habilitacionce
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'division', 'estado'], 'integer'],
            [['fecha'], 'safe'],
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
        $query = Habilitacionce::find();

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
            'division' => $this->division,
            'fecha' => $this->fecha,
            'estado' => $this->estado,
        ]);

        return $dataProvider;
    }
}
