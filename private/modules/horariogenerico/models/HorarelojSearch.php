<?php

namespace app\modules\horariogenerico\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\horariogenerico\models\Horareloj;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;

/**
 * HorarelojSearch represents the model behind the search form of `app\modules\horariogenerico\models\Horareloj`.
 */
class HorarelojSearch extends Horareloj
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'hora', 'anio', 'turno', 'semana'], 'integer'],
            [['inicio', 'fin'], 'safe'],
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
    public function porsemana($semana, $turno, $anio)
    {
        $query = Horareloj::find()
            ->where(['semana' => $semana])
            ->andWhere(['anio' => $anio])
            ->andWhere(['turno' => $turno])
            ->orderBy('anio, hora');

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
            'hora' => $this->hora,
            'anio' => $this->anio,
            'turno' => $this->turno,
            'semana' => $this->semana,
            'inicio' => $this->inicio,
            'fin' => $this->fin,
        ]);

        return $dataProvider;
    }
}
