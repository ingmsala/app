<?php

namespace app\modules\curriculares\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\curriculares\models\Acta;

/**
 * ActaSearch represents the model behind the search form of `app\modules\optativas\models\Acta`.
 */
class ActaSearch extends Acta
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'libro', 'rectifica', 'comision', 'estadoacta', 'user', 'escalanota'], 'integer'],
            [['nombre', 'fecha'], 'safe'],
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
    public function search($comision)
    {
        $query = Acta::find()
                    //->where(['libro' => $libro])
                    ->andWhere(['comision' => $comision]);

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
            'libro' => $this->libro,
            'rectifica' => $this->rectifica,
            'comision' => $this->comision,
            'estadoacta' => $this->estadoacta,
            'user' => $this->user,
            'fecha' => $this->fecha,
            'escalanota' => $this->escalanota,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
