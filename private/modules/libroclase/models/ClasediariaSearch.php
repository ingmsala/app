<?php

namespace app\modules\libroclase\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\libroclase\models\Clasediaria;

/**
 * ClasediariaSearch represents the model behind the search form of `app\modules\libroclase\models\Clasediaria`.
 */
class ClasediariaSearch extends Clasediaria
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'catedra', 'agente', 'modalidadclase', 'aniolectivo', 'tipocurricula'], 'integer'],
            [['fecha', 'fechacarga', 'observaciones'], 'safe'],
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
    public function porcatedra($cat, $al)
    {
        $query = Clasediaria::find()
                    ->where(['catedra' => $cat])
                    ->andWhere(['aniolectivo' => $al])
                    ->orderBy('fecha DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($cat);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'catedra' => $this->catedra,
            'fecha' => $this->fecha,
            'fechacarga' => $this->fechacarga,
            'agente' => $this->agente,
            'modalidadclase' => $this->modalidadclase,
        ]);

        $query->andFilterWhere(['like', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
