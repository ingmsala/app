<?php

namespace app\modules\mones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mones\models\Monacademica;

/**
 * MonacademicaSearch represents the model behind the search form of `app\modules\mones\models\Monacademica`.
 */
class MonacademicaSearch extends Monacademica
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'alumno'], 'integer'],
            [['curso', 'condicion', 'nota', 'materia', 'fecha'], 'safe'],
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
    public function xalumnoymateria($doc, $car)
    {
        $query = Monacademica::find()
                        ->joinWith(['materia0'])
                        ->where(['alumno'=>$doc])
                        ->andWhere(['monmateria.carrera' => $car]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
       
        return $dataProvider;
    }
}
