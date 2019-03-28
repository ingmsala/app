<?php

namespace app\modules\optativas\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\optativas\models\Matricula;

/**
 * MatriculaSearch represents the model behind the search form of `app\modules\optativas\models\Matricula`.
 */
class MatriculaSearch extends Matricula
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'alumno', 'comision', 'estadomatricula'], 'integer'],
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
    public function search($params)
    {
        $query = Matricula::find()
                ->joinWith(['alumno0', 'comision0', 'comision0.optativa0', 'comision0.optativa0.actividad0'])
                ->orderBy('actividad.nombre, comision.nombre, alumno.apellido, alumno.nombre');

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
            'alumno' => $this->alumno,
            'comision' => $this->comision,
            'estadomatricula' => $this->estadomatricula,
        ]);

        return $dataProvider;
    }

    public function alumnosxcomision($comsion)
    {
        $query = Matricula::find()
                ->joinWith(['alumno0', 'comision0', 'comision0.optativa0', 'comision0.optativa0.actividad0'])
                ->where(['comision.id' => $comsion])
                ->orderBy('actividad.nombre, comision.nombre, alumno.apellido, alumno.nombre');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($comsion);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha' => $this->fecha,
            'alumno' => $this->alumno,
            'comision' => $this->comision,
            'estadomatricula' => $this->estadomatricula,
        ]);

        return $dataProvider;
    }
}
