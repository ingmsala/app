<?php

namespace app\modules\edh\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edh\models\Actuacionedh;

/**
 * ActuacionedhSearch represents the model behind the search form of `app\modules\edh\models\Actuacionedh`.
 */
class ActuacionedhSearch extends Actuacionedh
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'area', 'lugaractuacion', 'agente', 'tipoactuacion', 'caso'], 'integer'],
            [['fecha', 'registro', 'fechacreate'], 'safe'],
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
    public function porCaso($id)
    {
        $query = Actuacionedh::find()->where(['caso' => $id])->andWhere(['log' => 1]);

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
            'area' => $this->area,
            'fecha' => $this->fecha,
            'lugaractuacion' => $this->lugaractuacion,
            'fechacreate' => $this->fechacreate,
            'agente' => $this->agente,
            'tipoactuacion' => $this->tipoactuacion,
        ]);

        $query->andFilterWhere(['like', 'registro', $this->registro]);

        return $dataProvider;
    }
}
