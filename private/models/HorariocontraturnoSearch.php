<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Horariocontraturno;

/**
 * HorariocontraturnoSearch represents the model behind the search form of `app\models\Horariocontraturno`.
 */
class HorariocontraturnoSearch extends Horariocontraturno
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'catedra', 'diasemana', 'aniolectivo'], 'integer'],
            [['inicio', 'fin'], 'safe'],
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
    public function porDivision($division, $al)
    {
        $query = Horariocontraturno::find()
                    ->joinWith(['catedra0'])
                    ->where(['catedra.division' => $division])
                    ->andWhere(['horariocontraturno.aniolectivo' => $al])
                    ->orderBy('horariocontraturno.diasemana, horariocontraturno.inicio');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'catedra' => $this->catedra,
            'inicio' => $this->inicio,
            'fin' => $this->fin,
            'diasemana' => $this->diasemana,
            'aniolectivo' => $this->aniolectivo,
        ]);

        return $dataProvider;
    }
}
