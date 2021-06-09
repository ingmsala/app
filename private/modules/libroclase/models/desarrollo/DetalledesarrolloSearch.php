<?php

namespace app\modules\libroclase\models\desarrollo;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\libroclase\models\desarrollo\Detalledesarrollo;

/**
 * DetalledesarrolloSearch represents the model behind the search form of `app\modules\libroclase\models\desarrollo\Detalledesarrollo`.
 */
class DetalledesarrolloSearch extends Detalledesarrollo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'temaunidad', 'estado', 'desarrollo'], 'integer'],
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
        $query = Detalledesarrollo::find();

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
            'temaunidad' => $this->temaunidad,
            'estado' => $this->estado,
            'desarrollo' => $this->desarrollo,
        ]);

        return $dataProvider;
    }
}
