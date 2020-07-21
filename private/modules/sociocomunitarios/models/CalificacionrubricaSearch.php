<?php

namespace app\modules\sociocomunitarios\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sociocomunitarios\models\Calificacionrubrica;

/**
 * CalificacionrubricaSearch represents the model behind the search form of `app\modules\sociocomunitarios\models\Calificacionrubrica`.
 */
class CalificacionrubricaSearch extends Calificacionrubrica
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rubrica', 'detalleescalanota'], 'integer'],
            [['descripcion'], 'safe'],
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
        $query = Calificacionrubrica::find();

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
            'rubrica' => $this->rubrica,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    public function porrubrica($id)
    {
        $query = Calificacionrubrica::find()->where(['rubrica' => $id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'rubrica' => $this->rubrica,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
