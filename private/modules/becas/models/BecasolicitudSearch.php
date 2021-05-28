<?php

namespace app\modules\becas\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\becas\models\Becasolicitud;

/**
 * BecasolicitudSearch represents the model behind the search form of `app\modules\becas\models\Becasolicitud`.
 */
class BecasolicitudSearch extends Becasolicitud
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'solicitante', 'convocatoria', 'estado', 'estudiante'], 'integer'],
            [['fecha', 'token'], 'safe'],
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
        $query = Becasolicitud::find();

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
            'solicitante' => $this->solicitante,
            'convocatoria' => $this->convocatoria,
            'estado' => $this->estado,
            'estudiante' => $this->estudiante,
        ]);

        $query->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
