<?php

namespace app\modules\solicitudprevios\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\solicitudprevios\models\Detallesolicitudext;

/**
 * DetallesolicitudextSearch represents the model behind the search form of `app\modules\solicitudprevios\models\Detallesolicitudext`.
 */
class DetallesolicitudextSearch extends Detallesolicitudext
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'actividad', 'solicitud', 'estado'], 'integer'],
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
    public function search($turno)
    {
        $query = Detallesolicitudext::find()
                    ->joinWith(['solicitud0', 'actividad0', 'estado0'])
                    ->where(['solicitudinscripext.turno' => $turno])
                    ->andWhere(['<>', 'estadoxsolicitudext.estado', 3])
                    ->orderBy('actividad.nombre, solicitudinscripext.apellido, solicitudinscripext.nombre');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
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
            'actividad' => $this->actividad,
            'solicitud' => $this->solicitud,
        ]);

        return $dataProvider;
    }

    public function porcontrol($turno)
    {
        $query = Detallesolicitudext::find()
                    ->joinWith(['solicitud0', 'actividad0'])
                    ->where(['solicitudinscripext.turno' => $turno])
                    ->orderBy('solicitudinscripext.apellido, solicitudinscripext.nombre, actividad.nombre');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
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
            'actividad' => $this->actividad,
            'solicitud' => $this->solicitud,
        ]);

        return $dataProvider;
    }

    public function pormateria($turno, $actividad)
    {
        $query = Detallesolicitudext::find()
                    ->joinWith(['solicitud0', 'actividad0', 'estado0'])
                    ->where(['solicitudinscripext.turno' => $turno])
                    ->andWhere(['detallesolicitudext.actividad' => $actividad])
                    ->andWhere(['<>', 'estadoxsolicitudext.estado', 3])
                    ->orderBy('solicitudinscripext.apellido, solicitudinscripext.nombre');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
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
            'actividad' => $this->actividad,
            'solicitud' => $this->solicitud,
        ]);

        return $dataProvider;
    }

    
}
