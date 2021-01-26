<?php

namespace app\modules\edh\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edh\models\Seguimientoplan;

/**
 * SeguimientoplanSearch represents the model behind the search form of `app\modules\edh\models\Seguimientoplan`.
 */
class SeguimientoplanSearch extends Seguimientoplan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'plan'], 'integer'],
            [['fecha', 'descripcion'], 'safe'],
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
    public function porPlan($plan)
    {
        $query = Seguimientoplan::find()->where(['plan' => $plan]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha' => $this->fecha,
            'plan' => $this->plan,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
