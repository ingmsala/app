<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Estadoinasistenciaxparte;

/**
 * EstadoinasistenciaxparteSearch represents the model behind the search form of `app\models\Estadoinasistenciaxparte`.
 */
class EstadoinasistenciaxparteSearch extends Estadoinasistenciaxparte
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estadoinasistencia', 'detalleparte', 'falta'], 'integer'],
            [['detalle', 'fecha'], 'safe'],
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
        $query = Estadoinasistenciaxparte::find();

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
            'estadoinasistencia' => $this->estadoinasistencia,
            'fecha' => $this->fecha,
            'detalleparte' => $this->detalleparte,
        ]);

        $query->andFilterWhere(['like', 'detalle', $this->detalle]);

        return $dataProvider;
    }

    public function nuevo($detalle=null, $estadoinasistencia, $detalleparte, $falta){
        $model = new Estadoinasistenciaxparte;
        $model->detalle = $detalle;
        $model->estadoinasistencia = $estadoinasistencia;
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $model->fecha = date("Y-m-d H:i:s");
        $model->detalleparte = $detalleparte;
        $model->falta = $falta;
        if ($model->save()){
            return true;
        }else{
            return false;
        }


    }
}
