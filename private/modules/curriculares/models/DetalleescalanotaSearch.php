<?php

namespace app\modules\curriculares\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\curriculares\models\Detalleescalanota;

/**
 * DetalleescalanotaSearch represents the model behind the search form of `app\modules\optativas\models\Detalleescalanota`.
 */
class DetalleescalanotaSearch extends Detalleescalanota
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'escalanota', 'condicionnota'], 'integer'],
            [['nota'], 'safe'],
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
    public function search($escalanota)
    {
        $query = Detalleescalanota::find()->where(['escalanota' =>$escalanota]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($escalanota);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'escalanota' => $this->escalanota,
            'condicionnota' => $this->condicionnota,
        ]);

        $query->andFilterWhere(['like', 'nota', $this->nota]);

        return $dataProvider;
    }
}
