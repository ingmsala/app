<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mesaexamen;

/**
 * MesaexamenSearch represents the model behind the search form of `app\models\Mesaexamen`.
 */
class MesaexamenSearch extends Mesaexamen
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'turnoexamen', 'espacio', 'turnohorario'], 'integer'],
            [['fecha', 'hora', 'nombre'], 'safe'],
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
    public function search($turno, $all)
    {
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();

        if($agente != null){
            $tribunal = Tribunal::find()->where(['agente' => $agente->id])->all();

            $arr = array_column($tribunal, 'mesaexamen');

            $query = Mesaexamen::find()
                        ->where(['turnoexamen' => $turno])
                        ->andWhere(['in', 'id', $arr])
                        ->orderBy('fecha, hora');
        }else{
            $query = Mesaexamen::find()->where(['turnoexamen' => $turno])->orderBy('fecha, hora');
        }
        if($all == 1){
            $query = Mesaexamen::find()->where(['turnoexamen' => $turno])->orderBy('fecha, hora');
        }
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $this->load($turno);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'nombre' => $this->nombre,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'turnoexamen' => $this->turnoexamen,
            'espacio' => $this->espacio,
        ]);

        return $dataProvider;
    }
}
