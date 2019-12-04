<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Actividadesmantenimiento;

/**
 * ActividadesmantenimientoSearch represents the model behind the search form of `app\models\Actividadesmantenimiento`.
 */
class ActividadesmantenimientoSearch extends Actividadesmantenimiento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario', 'tareamantenimiento'], 'integer'],
            [['fecha', 'observaciones'], 'safe'],
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
        $query = Actividadesmantenimiento::find();

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
            'usuario' => $this->usuario,
            'tareamantenimiento' => $this->tareamantenimiento,
        ]);

        $query->andFilterWhere(['like', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }

    public function actividadesxTarea($tarea)
    {
        $query = Actividadesmantenimiento::find()->where(['tareamantenimiento' => $tarea]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($tarea);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha' => $this->fecha,
            'usuario' => $this->usuario,
            'tareamantenimiento' => $this->tareamantenimiento,
        ]);

        $query->andFilterWhere(['like', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
