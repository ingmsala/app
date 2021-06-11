<?php

namespace app\modules\sociocomunitarios\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sociocomunitarios\models\Detalleactividadpsc;

/**
 * DetalleactividadpsccSearch represents the model behind the search form of `app\modules\sociocomunitarios\models\Detalleactividadpsc`.
 */
class DetalleactividadpscSearch extends Detalleactividadpsc
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'actividad', 'matricula', 'presentacion', 'calificacion'], 'integer'],
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
    public function xmatricula($id)
    {
        $query = Detalleactividadpsc::find()
                    ->where(['matricula' => $id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'actividad' => $this->actividad,
            'matricula' => $this->matricula,
            'presentacion' => $this->presentacion,
            'calificacion' => $this->calificacion,
        ]);

        return $dataProvider;
    }
}
