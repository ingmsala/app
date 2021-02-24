<?php

namespace app\modules\solicitudprevios\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\solicitudprevios\models\Solicitudinscripext;

/**
 * SolicitudinscripextSearch represents the model behind the search form of `app\modules\solicitudprevios\models\Solicitudinscripext`.
 */
class SolicitudinscripextSearch extends Solicitudinscripext
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'turno'], 'integer'],
            [['apellido', 'nombre', 'documento', 'fecha', 'mail', 'telefono'], 'safe'],
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
        $query = Solicitudinscripext::find();

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
            'turno' => $this->turno,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'documento', $this->documento])
            ->andFilterWhere(['like', 'mail', $this->mail])
            ->andFilterWhere(['like', 'telefono', $this->telefono]);

        return $dataProvider;
    }
}
