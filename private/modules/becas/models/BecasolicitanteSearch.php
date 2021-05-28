<?php

namespace app\modules\becas\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\becas\models\Becasolicitante;

/**
 * BecasolicitanteSearch represents the model behind the search form of `app\modules\becas\models\Becasolicitante`.
 */
class BecasolicitanteSearch extends Becasolicitante
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parentesco', 'nivelestudio', 'negativaanses', 'persona', 'conviviente'], 'integer'],
            [['apellido', 'nombre', 'cuil', 'mail', 'telefono', 'fechanac', 'domicilio'], 'safe'],
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
        $query = Becasolicitante::find();

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
            'parentesco' => $this->parentesco,
            'nivelestudio' => $this->nivelestudio,
            'negativaanses' => $this->negativaanses,
            'persona' => $this->persona,
        ]);

        $query->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'cuil', $this->cuil])
            ->andFilterWhere(['like', 'mail', $this->mail])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'domicilio', $this->domicilio]);

        return $dataProvider;
    }
}
