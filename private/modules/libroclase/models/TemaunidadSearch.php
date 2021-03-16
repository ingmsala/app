<?php

namespace app\modules\libroclase\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\libroclase\models\Temaunidad;
use yii\data\ArrayDataProvider;

/**
 * TemaunidadSearch represents the model behind the search form of `app\modules\libroclase\models\Temaunidad`.
 */
class TemaunidadSearch extends Temaunidad
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'detalleunidad', 'prioridad'], 'integer'],
            [['horasesperadas'], 'number'],
            [['descripcion'], 'safe'],
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
    public function pordetalleunidad($du)
    {
        $query = Temaunidad::find()->where(['detalleunidad' => $du])->orderBy('prioridad');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($du);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'detalleunidad' => $this->detalleunidad,
            'horasesperadas' => $this->horasesperadas,
            'prioridad' => $this->prioridad,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    public function pordetalleunidadycat($du, $cat)
    {
        /*$query = Temaunidad::find()
                    ->where(['detalleunidad' => $du])
                    ->orderBy('prioridad');*/

        $temas = Temaunidad::find()
                    ->where(['detalleunidad' => $du])
                    ->orderBy('prioridad')
                    ->all();

        $array = [];

        foreach ($temas as $key => $tema) {
            $array[$key]['id'] = $tema->id;
            $array[$key]['descripcion'] = $tema->descripcion;
            $array[$key]['prioridad'] = $tema->prioridad;

            $cantparcial = Temaxclase::find()
                    ->joinWith(['clasediaria0', 'clasediaria0.horaxclases'])
                    ->where(['clasediaria.catedra' => $cat])
                    ->andWhere(['temaxclase.temaunidad' => $tema->id])
                    ->andWhere(['clasediaria.aniolectivo' => 3])
                    ->andWhere(['temaxclase.tipodesarrollo' => 1])
                    ->count();

            $canttotal = Temaxclase::find()
                ->joinWith(['clasediaria0', 'clasediaria0.horaxclases'])
                ->where(['clasediaria.catedra' => $cat])
                ->andWhere(['temaxclase.temaunidad' => $tema->id])
                ->andWhere(['clasediaria.aniolectivo' => 3])
                ->andWhere(['temaxclase.tipodesarrollo' => 2])
                ->count();

            $suma = $cantparcial + $canttotal;
            if ($suma > 0){
                if($canttotal > 0){
                    $array[$key]['desarrollo'] = 'Completo';
                    $array[$key]['desarrolloid'] = '2';
                }else{
                    $array[$key]['desarrollo'] = 'Parcial';
                    $array[$key]['desarrolloid'] = '0';
                }
            }else{
                $array[$key]['desarrollo'] = '';
                $array[$key]['desarrolloid'] = '0';
            }
            if($suma>0)
                $array[$key]['total'] = $suma;
            else
                $array[$key]['total'] = '';

        }

        array_multisort(array_column($array, 'desarrolloid'), SORT_ASC, $array);

        // add conditions that should always apply here

        /*$dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);*/

        $dataProvider = new ArrayDataProvider([
            'allModels' => $array,
            'pagination' => false,
        ]);

        /*$this->load($du);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'detalleunidad' => $this->detalleunidad,
            'horasesperadas' => $this->horasesperadas,
            'prioridad' => $this->prioridad,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);*/

        return $dataProvider;
    }
}
