<?php

namespace app\models;

use app\config\Globales;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Turnoexamen;

/**
 * TurnoexamenSearch represents the model behind the search form of `app\models\Turnoexamen`.
 */
class TurnoexamenSearch extends Turnoexamen
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipoturno', 'activo'], 'integer'],
            [['nombre', 'desde', 'hasta'], 'safe'],
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
        if(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_CONSULTA, Globales::US_DIRECCION, Globales::US_PRECEPTORIA, Globales::US_PRECEPTOR]))
            $query = Turnoexamen::find()->where(['activo' => 2])->orderBy('desde desc');
        else
            $query = Turnoexamen::find()->orderBy('desde desc');

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
            'desde' => $this->desde,
            'hasta' => $this->hasta,
            'tipoturno' => $this->tipoturno,
            'activo' => $this->activo,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
