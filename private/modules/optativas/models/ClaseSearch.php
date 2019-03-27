<?php

namespace app\modules\optativas\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\optativas\models\Clase;

/**
 * ClaseSearch represents the model behind the search form of `app\modules\optativas\models\Clase`.
 */
class ClaseSearch extends Clase
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipoclase', 'comision'], 'integer'],
            [['fecha', 'tema'], 'safe'],
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
        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        $query = Clase::find()
            ->where(['comision' => $com])
            ->orderBy('fecha DESC');

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
            'fecha' => $this->fecha,
            'tipoclase' => $this->tipoclase,
            'comision' => $this->comision,
        ]);

        $query->andFilterWhere(['like', 'tema', $this->tema]);

        return $dataProvider;
    }
}
