<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Catedra;

/**
 * CatedraSearch represents the model behind the search form of `app\models\Catedra`.
 */
class CatedraSearch extends Catedra
{
    public $actividad;
    public $division;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', ], 'integer'],
            [['division', 'actividad'], 'safe'],
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
        $query = Catedra::find()->joinWith(['actividad0', 'division0']);

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

        $dataProvider->sort->attributes['actividad0'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['actividad.nombre' => SORT_ASC],
        'desc' => ['actividad.nombre' => SORT_DESC],
        ];
        // Lets do the same with country now
        $dataProvider->sort->attributes['division0'] = [
        'asc' => ['division.nombre' => SORT_ASC],
        'desc' => ['division.nombre' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            
        ]);

        $query->andFilterWhere(['like', 'actividad.nombre', $this->actividad])
        ->andFilterWhere(['like', 'division.nombre', $this->division]);;

        return $dataProvider;
    }
}
