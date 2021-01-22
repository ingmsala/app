<?php

namespace app\modules\edh\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edh\models\Solicitudedh;

/**
 * SolicitudedhSearch represents the model behind the search form of `app\modules\edh\models\Solicitudedh`.
 */
class SolicitudedhSearch extends Solicitudedh
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'areasolicitud', 'caso', 'demandante', 'estadosolicitud', 'tiposolicitud'], 'integer'],
            [['fecha', 'expediente', 'fechaexpediente'], 'safe'],
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
    public function porCaso($id)
    {
        $query = Solicitudedh::find()->where(['caso' => $id])->indexBy('id');

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
            'fecha' => $this->fecha,
            'areasolicitud' => $this->areasolicitud,
            'caso' => $this->caso,
            'demandante' => $this->demandante,
            'estadosolicitud' => $this->estadosolicitud,
            'tiposolicitud' => $this->tiposolicitud,
        ]);

        return $dataProvider;
    }
}
