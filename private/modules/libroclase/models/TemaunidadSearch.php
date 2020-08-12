<?php

namespace app\modules\libroclase\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\libroclase\models\Temaunidad;

/**
 * TemaunidadSearch represents the model behind the search form of `app\modules\libroclase\models\Temaunidad`.
 */
class TemaunidadSearch extends Temaunidad
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'detalleunidad', 'prioridad'], 'integer'],
            [['horasesperadas'], 'number'],
            [['descripcion'], 'safe'],
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
    public function pordetalleunidad($du)
    {
        $query = Temaunidad::find()->where(['detalleunidad' => $du])->orderBy('prioridad');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($du);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'detalleunidad' => $this->detalleunidad,
            'horasesperadas' => $this->horasesperadas,
            'prioridad' => $this->prioridad,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
