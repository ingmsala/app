<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Detallefonid;

/**
 * DetallefonidSearch represents the model behind the search form of `app\models\Detallefonid`.
 */
class DetallefonidSearch extends Detallefonid
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipo', 'fonid'], 'integer'],
            [['jurisdiccion', 'denominacion', 'nombre', 'cargo', 'observaciones'], 'safe'],
            [['horas'], 'number'],
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
    public function search($id)
    {
        $query = Detallefonid::find()->where(['fonid' => $id]);

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
            'horas' => $this->horas,
            'tipo' => $this->tipo,
            'fonid' => $this->fonid,
        ]);

        $query->andFilterWhere(['like', 'jurisdiccion', $this->jurisdiccion])
            ->andFilterWhere(['like', 'denominacion', $this->denominacion])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'cargo', $this->cargo])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
