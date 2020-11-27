<?php

namespace app\modules\mones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mones\models\Monmatricula;

/**
 * MonmatriculaSearch represents the model behind the search form of `app\modules\mones\models\Monmatricula`.
 */
class MonmatriculaSearch extends Monmatricula
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'alumno', 'carrera', 'libro', 'folio'], 'integer'],
            [['certificado'], 'safe'],
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
        $query = Monmatricula::find();

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
            'alumno' => $this->alumno,
            'carrera' => $this->carrera,
            'certificado' => $this->certificado,
            'libro' => $this->libro,
            'folio' => $this->folio,
        ]);

        return $dataProvider;
    }
}
