<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Detalleparte;

/**
 * DetalleparteSearch represents the model behind the search form of `app\models\Detalleparte`.
 */
class DetalleparteSearch extends Detalleparte
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parte', 'division', 'docente', 'hora', 'llego', 'retiro', 'falta'], 'integer'],
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
        $query = Detalleparte::find();

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
            'parte' => $this->parte,
            'division' => $this->division,
            'docente' => $this->docente,
            'hora' => $this->hora,
            'llego' => $this->llego,
            'retiro' => $this->retiro,
            'falta' => $this->falta,
        ]);

        return $dataProvider;
    }

    public function providerxparte($id)
    {
        $query = Detalleparte::find()
            ->where(['parte' => $id,
                //'condicion' => 5 //suplente
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }

    
}
