<?php

namespace app\modules\becas\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\becas\models\Becaestadoxsolicitud;

/**
 * BecaestadoxsolicitudSearch represents the model behind the search form of `app\modules\becas\models\Becaestadoxsolicitud`.
 */
class BecaestadoxsolicitudSearch extends Becaestadoxsolicitud
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'solicitud', 'estado', 'agente'], 'integer'],
            [['fecha', 'comentario'], 'safe'],
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
        $query = Becaestadoxsolicitud::find();

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
            'solicitud' => $this->solicitud,
            'estado' => $this->estado,
            'fecha' => $this->fecha,
            'agente' => $this->agente,
        ]);

        $query->andFilterWhere(['like', 'comentario', $this->comentario]);

        return $dataProvider;
    }
}
