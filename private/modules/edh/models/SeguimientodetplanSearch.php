<?php

namespace app\modules\edh\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edh\models\Seguimientodetplan;

/**
 * SeguimientodetplanSearch represents the model behind the search form of `app\modules\edh\models\Seguimientodetplan`.
 */
class SeguimientodetplanSearch extends Seguimientodetplan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'detalleplan', 'creado'], 'integer'],
            [['fecha', 'descripcion', 'plazo'], 'safe'],
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
    public function porDetalle($det)
    {
        $query = Seguimientodetplan::find()->where(['detalleplan' => $det]);

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
            'fecha' => $this->fecha,
            'plazo' => $this->plazo,
            'detalleplan' => $this->detalleplan,
            'creado' => $this->creado,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
