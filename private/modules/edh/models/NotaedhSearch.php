<?php

namespace app\modules\edh\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edh\models\Notaedh;

/**
 * NotaedhSearch represents the model behind the search form of `app\modules\edh\models\Notaedh`.
 */
class NotaedhSearch extends Notaedh
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nota', 'tiponota', 'trimestre', 'detalleplancursado'], 'integer'],
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
        $query = Notaedh::find()->where(['detalleplancursado' => $det])->orderBy('trimestre, tiponota');

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
            'nota' => $this->nota,
            'tiponota' => $this->tiponota,
            'trimestre' => $this->trimestre,
            'detalleplancursado' => $this->detalleplancursado,
        ]);

        return $dataProvider;
    }
}
