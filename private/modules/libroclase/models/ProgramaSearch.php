<?php

namespace app\modules\libroclase\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\libroclase\models\Programa;

/**
 * ProgramaSearch represents the model behind the search form of `app\modules\libroclase\models\Programa`.
 */
class ProgramaSearch extends Programa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'plan', 'actividad', 'vigencia'], 'integer'],
            [['version'], 'safe'],
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
    public function poractividad($id)
    {
        $query = Programa::find()->where(['actividad' => $id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($id);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'plan' => $this->plan,
            'actividad' => $this->actividad,
            'vigencia' => $this->vigencia,
        ]);

        $query->andFilterWhere(['like', 'version', $this->version]);

        return $dataProvider;
    }
}
