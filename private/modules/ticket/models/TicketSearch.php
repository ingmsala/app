<?php

namespace app\modules\ticket\models;

use app\models\Agente;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\ticket\models\Ticket;

/**
 * TicketSearch represents the model behind the search form of `app\modules\ticket\models\Ticket`.
 */
class TicketSearch extends Ticket
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estadoticket', 'agente', 'asignacionticket', 'prioridadticket', 'clasificacionticket'], 'integer'],
            [['fecha', 'hora', 'asunto', 'descripcion'], 'safe'],
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
    public function search2($params)
    {
        $query = Ticket::find();

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
            'hora' => $this->hora,
            'estadoticket' => $this->estadoticket,
            'agente' => $this->agente,
            'asignacionticket' => $this->asignacionticket,
            'prioridadticket' => $this->prioridadticket,
            'clasificacionticket' => $this->clasificacionticket,
        ]);

        $query->andFilterWhere(['like', 'asunto', $this->asunto])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }


    public function misabiertosycerrados($params)
    {
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

        $query = Ticket::find()
                    ->joinWith(['detalletickets', 'detalletickets.asignacionticket0 detasig', 'asignacionticket0 ticasig', 
                                    'asignacionticket0.areaticket0.grupotrabajotickets detgrupo'])
                    ->where([
                        'or',
                        ['ticket.agente' => $agente->id],
                        ['detalleticket.agente' => $agente->id],
                        ['detasig.agente' => $agente->id],
                        ['ticasig.agente' => $agente->id],

                        ['detgrupo.agente' => $agente->id],

                    ])
                    ->orderBy('id desc');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ]
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
            'hora' => $this->hora,
            'estadoticket' => $this->estadoticket,
            'agente' => $this->agente,
            'asignacionticket' => $this->asignacionticket,
            'prioridadticket' => $this->prioridadticket,
            'clasificacionticket' => $this->clasificacionticket,
        ]);

        $query->andFilterWhere(['like', 'asunto', $this->asunto])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    public function misabiertos($params)
    {
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

        $query = Ticket::find()
                    ->joinWith(['detalletickets', 'detalletickets.asignacionticket0 detasig', 'asignacionticket0 ticasig', 
                                    'asignacionticket0.areaticket0.grupotrabajotickets detgrupo'])
                    ->where([
                        'or',
                        ['ticket.agente' => $agente->id],
                        ['detalleticket.agente' => $agente->id],
                        ['detasig.agente' => $agente->id],
                        ['ticasig.agente' => $agente->id],

                        ['detgrupo.agente' => $agente->id],

                    ])
                    ->andWhere(['ticket.estadoticket' => 1])
                    ->orderBy('id desc');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ]
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
            'hora' => $this->hora,
            'estadoticket' => $this->estadoticket,
            'agente' => $this->agente,
            'asignacionticket' => $this->asignacionticket,
            'prioridadticket' => $this->prioridadticket,
            'clasificacionticket' => $this->clasificacionticket,
        ]);

        $query->andFilterWhere(['like', 'asunto', $this->asunto])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    public function miscerrados($params)
    {
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

        $query = Ticket::find()
                    ->joinWith(['detalletickets', 'detalletickets.asignacionticket0 detasig', 'asignacionticket0 ticasig', 
                                    'asignacionticket0.areaticket0.grupotrabajotickets detgrupo'])
                    ->where([
                        'or',
                        ['ticket.agente' => $agente->id],
                        ['detalleticket.agente' => $agente->id],
                        ['detasig.agente' => $agente->id],
                        ['ticasig.agente' => $agente->id],

                        ['detgrupo.agente' => $agente->id],

                    ])
                    ->andWhere(['ticket.estadoticket' => 2])
                    ->orderBy('id desc');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ]
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
            'hora' => $this->hora,
            'estadoticket' => $this->estadoticket,
            'agente' => $this->agente,
            'asignacionticket' => $this->asignacionticket,
            'prioridadticket' => $this->prioridadticket,
            'clasificacionticket' => $this->clasificacionticket,
        ]);

        $query->andFilterWhere(['like', 'asunto', $this->asunto])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

}
