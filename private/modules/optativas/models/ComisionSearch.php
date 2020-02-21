<?php

namespace app\modules\optativas\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\optativas\models\Comision;

/**
 * ComisionSearch represents the model behind the search form of `app\modules\optativas\models\Comision`.
 */
class ComisionSearch extends Comision
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'optativa', 'cupo'], 'integer'],
            [['nombre','horario', 'aula'], 'safe'],
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
        $query = Comision::find()
            ->where(['optativa' => $params['id']]);

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
            'optativa' => $this->optativa,
            'cupo' => $this->cupo,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }

    public function comisionesxalumno($dni)
    {
        $query = Comision::find()
            ->joinWith(['matriculas', 'matriculas.estadomatricula0', 'optativa0', 'optativa0.aniolectivo0', 'matriculas.alumno0'])
            ->where(['alumno.dni' => $dni])
            ->orderBy('aniolectivo.nombre');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($dni);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        


        return $dataProvider;
    }

    
}
