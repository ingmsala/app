<?php

namespace app\modules\optativas\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\optativas\models\Inasistencia;

/**
 * InasistenciaSearch represents the model behind the search form of `app\modules\optativas\models\Inasistencia`.
 */
class InasistenciaSearch extends Inasistencia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'matricula', 'clase'], 'integer'],
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
        $query = Inasistencia::find();

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
            'matricula' => $this->matricula,
            'clase' => $this->clase,
        ]);

        return $dataProvider;
    }
}
