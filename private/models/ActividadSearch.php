<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Actividad;

/**
 * ActividadSearch represents the model behind the search form of `app\models\Actividad`.
 */
class ActividadSearch extends Actividad
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cantHoras',], 'integer'],
            [['nombre', 'actividadtipo', 'plan', 'propuesta'], 'safe'],
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
        $query = Actividad::find()->joinWith(['actividadtipo0', 'plan0', 'propuesta0']);

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

        $dataProvider->sort->attributes['actividadtipo0'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['actividadtipo.nombre' => SORT_ASC],
        'desc' => ['actividadtipo.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['plan0'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['plan.nombre' => SORT_ASC],
        'desc' => ['plan.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['propuesta0'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['propuesta.nombre' => SORT_ASC],
        'desc' => ['propuesta.nombre' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cantHoras' => $this->cantHoras,
            
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);
        $query->andFilterWhere(['like', 'actividadtipo.nombre', $this->actividadtipo]);
        $query->andFilterWhere(['like', 'plan.nombre', $this->plan]);
        $query->andFilterWhere(['like', 'propuesta.nombre', $this->propuesta]);

        return $dataProvider;
    }
}