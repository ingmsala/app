<?php

namespace app\modules\optativas\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\optativas\models\Seguimiento;

/**
 * SeguimientoSearch represents the model behind the search form of `app\modules\optativas\models\Seguimiento`.
 */
class SeguimientoSearch extends Seguimiento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'matricula', 'trimestre'], 'integer'],
            [['fecha', 'descripcion'], 'safe'],
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
        $query = Seguimiento::find();

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
            'fecha' => $this->fecha,
            'descripcion' => $this->descripcion,
        ]);

        return $dataProvider;
    }

    public function seguimientosdelalumno($id)
    {
        $query = Seguimiento::find()
                ->where(['matricula' => $id])
                ->orderBy('fecha DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($id);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'matricula' => $this->matricula,
            'fecha' => $this->fecha,
            'descripcion' => $this->descripcion,
        ]);

        return $dataProvider;
    }
}
