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
            [['id'], 'integer'],
            [['fecha', 'preceptoria'], 'safe'],
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
               ->where(['preceptoria.nombre' => $us])
               ->orderBy('fecha');
        }else{
            $query = Parte::find()->joinWith('preceptoria0')
                ->orderBy('fecha');
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

        $dataProvider->sort->attributes['preceptoria0'] = [
        'asc' => ['preceptoria.nombre' => SORT_ASC],
        'desc' => ['preceptoria.nombre' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha' => $this->fecha,
            
        ]);

        $query->andFilterWhere(['like', 'preceptoria.nombre', $this->preceptoria]);

        return $dataProvider;
    }
}
