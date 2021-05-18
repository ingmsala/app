<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Division;

/**
 * DivisionSearch represents the model behind the search form of `app\models\Division`.
 */
class DivisionSearch extends Division
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',], 'integer'],
            [['nombre', 'turno', 'propuesta', 'preceptoria', 'aula'], 'safe'],
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
        $query = Division::find()->joinWith(['turno0', 'propuesta0', 'preceptoria0']);

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

        $dataProvider->sort->attributes['propuesta0'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['propuesta.nombre' => SORT_ASC],
        'desc' => ['propuesta.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['turno0'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['turno.nombre' => SORT_ASC],
        'desc' => ['turno.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['preceptoria0'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['preceptoria.nombre' => SORT_ASC],
        'desc' => ['preceptoria.nombre' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);
        $query->andFilterWhere(['like', 'turno.nombre', $this->turno]);
        $query->andFilterWhere(['like', 'propuesta.nombre', $this->propuesta]);
        $query->andFilterWhere(['like', 'preceptoria.nombre', $this->preceptoria]);

        return $dataProvider;
    }

    
}
