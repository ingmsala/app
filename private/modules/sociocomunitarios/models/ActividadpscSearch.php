<?php

namespace app\modules\sociocomunitarios\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sociocomunitarios\models\Actividadpsc;

/**
 * ActividadpscSearch represents the model behind the search form of `app\modules\sociocomunitarios\models\Actividadpsc`.
 */
class ActividadpscSearch extends Actividadpsc
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'comision'], 'integer'],
            [['descripcion', 'fecha'], 'safe'],
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
    public function xcomision($com)
    {
        $query = Actividadpsc::find()
                    ->where(['comision' => $com])
                    ->orderBy('fecha');

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
            'comision' => $this->comision,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
