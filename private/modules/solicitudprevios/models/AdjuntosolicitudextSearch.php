<?php

namespace app\modules\solicitudprevios\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\solicitudprevios\models\Adjuntosolicitudext;

/**
 * AdjuntosolicitudextSearch represents the model behind the search form of `app\modules\solicitudprevios\models\Adjuntosolicitudext`.
 */
class AdjuntosolicitudextSearch extends Adjuntosolicitudext
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['solicitud'], 'integer'],
            [['url', 'nombre'], 'safe'],
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
        $query = Adjuntosolicitudext::find();

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
            'solicitud' => $this->solicitud,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
