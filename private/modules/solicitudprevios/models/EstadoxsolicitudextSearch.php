<?php

namespace app\modules\solicitudprevios\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\solicitudprevios\models\Estadoxsolicitudext;

/**
 * EstadoxsolicitudextSearch represents the model behind the search form of `app\modules\solicitudprevios\models\Estadoxsolicitudext`.
 */
class EstadoxsolicitudextSearch extends Estadoxsolicitudext
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estado', 'detalle', 'agente'], 'integer'],
            [['motivo', 'fecha'], 'safe'],
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
    public function search($det)
    {
        $query = Estadoxsolicitudext::find()->where(['detalle' =>$det]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($det);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'estado' => $this->estado,
            'detalle' => $this->detalle,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'motivo', $this->motivo]);

        return $dataProvider;
    }
}
