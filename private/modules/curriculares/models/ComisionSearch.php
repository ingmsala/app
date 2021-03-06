<?php

namespace app\modules\curriculares\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\curriculares\models\Comision;

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
            [['id', 'espaciocurricular', 'cupo'], 'integer'],
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
            ->where(['espaciocurricular' => $params['id']]);

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
            'optativa' => $this->espaciocurricular,
            'cupo' => $this->cupo,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }

    public function xdocentes($al)
    {
        $query = Comision::find()
            ->joinWith(['espaciocurricular0'])
            ->where(['espaciocurricular.aniolectivo' => $al]);

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
            'optativa' => $this->espaciocurricular,
            'cupo' => $this->cupo,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }

    public function comisionesxalumno($documento)
    {
        $query = Comision::find()
            ->joinWith(['matriculas', 'matriculas.estadomatricula0', 'espaciocurricular0', 'espaciocurricular0.aniolectivo0', 'matriculas.alumno0'])
            ->where(['alumno.documento' => $documento])
            ->orderBy('aniolectivo.nombre');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($documento);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        


        return $dataProvider;
    }

    
}
