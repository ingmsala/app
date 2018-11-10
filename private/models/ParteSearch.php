<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Parte;

/**
 * ParteSearch represents the model behind the search form of `app\models\Parte`.
 */
class ParteSearch extends Parte
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'preceptoria'], 'integer'],
            [['fecha'], 'safe'],
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
        $us = Yii::$app->user->identity->username;
        if ( !in_array ($us, ["msala", "secretaria"])) {
        $query = Parte::find()->joinWith('preceptoria0')
               ->where(['preceptoria.nombre' => $us]);
        }else{
            $query = Parte::find();
        }

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
            'fecha' => $this->fecha,
            'preceptoria' => $this->preceptoria,
        ]);

        return $dataProvider;
    }
}
