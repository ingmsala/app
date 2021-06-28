<?php

namespace app\modules\ticket\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\ticket\models\Authpago;

/**
 * AuthpagoSearch represents the model behind the search form of `app\modules\ticket\models\Authpago`.
 */
class AuthpagoSearch extends Authpago
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ticket', 'proveedor', 'estado'], 'integer'],
            [['fecha', 'ordenpago'], 'safe'],
            [['monto'], 'number'],
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
        $query = Authpago::find()
                ->where(['activo' => 1])
                ->orderBy('fecha DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
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
            'ticket' => $this->ticket,
            'proveedor' => $this->proveedor,
            'estado' => $this->estado,
            'fecha' => $this->fecha,
            'monto' => $this->monto,
        ]);

        $query->andFilterWhere(['like', 'ordenpago', $this->ordenpago]);

        return $dataProvider;
    }
}
