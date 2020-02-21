<?php

namespace app\modules\optativas\models;

use Yii;
use app\modules\optativas\models\Optativa;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * OptativaSearch represents the model behind the search form of `app\modules\optativas\models\Optativa`.
 */
class OptativaSearch extends Optativa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'actividad', 'aniolectivo', 'duracion', 'areaoptativa'], 'integer'],
            
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
        $query = Optativa::find();

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
            'actividad' => $this->actividad,
            'aniolectivo' => $this->aniolectivo,
            'duracion' => $this->duracion,
            'areaoptativa' => $this->areaoptativa,
        ]);

        return $dataProvider;
    }

    public function porCursos($alumno)
    {
        $sql = "SELECT comi.id AS idcomi, act.nombre AS actividad, op.curso AS curso, comi.nombre AS comision, op.resumen AS resumen, comi.horario AS horario, comi.aula AS aula 
                FROM `optativa` op
                left join comision comi ON comi.optativa = op.id
                left join actividad act ON op.actividad = act.id
                left join aniolectivo al2 on op.aniolectivo = al2.id
                WHERE op.curso in 
                (select curso from admisionoptativa ao left join aniolectivo al on ao.aniolectivo = al.id where alumno = ".$alumno." and al.activo=1)
                AND al2.activo=1
                order by op.curso, act.nombre";

        // add conditions that should always apply here

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
        ]);

        $this->load($alumno);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        

        return $dataProvider;
    }
}
