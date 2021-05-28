<?php

namespace app\modules\becas\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\becas\models\Becaconviviente;

/**
 * BecaconvivienteSearch represents the model behind the search form of `app\modules\becas\models\Becaconviviente`.
 */
class BecaconvivienteSearch extends Becaconviviente
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nivelestudio', 'negativaanses', 'parentesco', 'solicitud', 'persona'], 'integer'],
            [['apellido', 'nombre', 'cuil', 'fechanac'], 'safe'],
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
        $query = Becaconviviente::find();

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
            'fechanac' => $this->fechanac,
            'nivelestudio' => $this->nivelestudio,
            'negativaanses' => $this->negativaanses,
            'parentesco' => $this->parentesco,
            'solicitud' => $this->solicitud,
            'persona' => $this->persona,
        ]);

        $query->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'cuil', $this->cuil]);

        return $dataProvider;
    }
}
