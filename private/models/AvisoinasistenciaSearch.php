<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Avisoinasistencia;

/**
 * AvisoinasistenciaSearch represents the model behind the search form of `app\models\Avisoinasistencia`.
 */
class AvisoinasistenciaSearch extends Avisoinasistencia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'agente', 'tipoavisoparte'], 'integer'],
            [['descripcion', 'desde', 'hasta'], 'safe'],
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
    public function search($todos)
    {
        if($todos == 2)
            $query = Avisoinasistencia::find()
                    ->where(['year(desde)'=>date('Y')])
                    ->andWhere(['tipoavisoparte' => 2])
                    ->orderBy('desde DESC');
        else
            $query = Avisoinasistencia::find()
                    ->where(['year(desde)'=>date('Y')])
                    ->orderBy('desde DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($todos);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'agente' => $this->agente,
            'desde' => $this->desde,
            'hasta' => $this->hasta,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    public function providerFromParte($fechaparte)
    {

        $query = Avisoinasistencia::find()
                    ->joinWith(['agente0'])
                    //->where(['BETWEEN','desde', 'hasta', $fechaparte, 'hasta'])
                    //->where(['<=','desde',$fechaparte])
                    ->andWhere(['>=','hasta',$fechaparte])
                    ->orderBy('agente.apellido ASC');

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
            'agente' => $this->agente,
            'desde' => $this->desde,
            'hasta' => $this->hasta,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
