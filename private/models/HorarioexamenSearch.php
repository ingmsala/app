<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Horarioexamen;

/**
 * HorarioexamenSearch represents the model behind the search form of `app\models\Horarioexamen`.
 */
class HorarioexamenSearch extends Horarioexamen
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'catedra', 'hora', 'tipo', 'anioxtrimestral', 'cambiada'], 'integer'],
            [['fecha'], 'safe'],
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
    public function search($id)
    {
        $query = Horarioexamen::find()->joinWith(['catedra0', 'catedra0.division0'])->where(['anioxtrimestral' => $id])->orderBy('division.id, horarioexamen.fecha, horarioexamen.hora');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'catedra' => $this->catedra,
            'hora' => $this->hora,
            'tipo' => $this->tipo,
            'anioxtrimestral' => $this->anioxtrimestral,
            'fecha' => $this->fecha,
            'cambiada' => $this->cambiada,
        ]);

        return $dataProvider;
    }
}
