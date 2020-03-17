<?php

namespace app\modules\curriculares\models;

use app\models\Parametros;
use Yii;
use app\modules\curriculares\models\Espaciocurricular;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * EspaciocurricularSearch represents the model behind the search form of `app\modules\optativas\models\Espaciocurricular`.
 */
class EspaciocurricularSearch extends Espaciocurricular
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'actividad', 'aniolectivo', 'duracion', 'areaoptativa', 'tipoespacio'], 'integer'],
            
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
    public function search($tipoespacio)
    {
        $query = Espaciocurricular::find()->where(['tipoespacio' => $tipoespacio]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$this->load($params);

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
        $prioridad = Parametros::findOne(4);
        if($prioridad->estado == 1){
        $sql = "SELECT comi.id AS idcomi, act.nombre AS actividad, op.curso AS curso, comi.nombre AS comision, op.resumen AS resumen, comi.horario AS horario, comi.aula AS aula 
                FROM `espaciocurricular` op
                left join comision comi ON comi.espaciocurricular = op.id
                left join actividad act ON op.actividad = act.id
                left join aniolectivo al2 on op.aniolectivo = al2.id
                WHERE op.curso in 
                (select max(curso) from admisionoptativa ao left join aniolectivo al on ao.aniolectivo = al.id where alumno = ".$alumno." and al.activo=1)
                AND al2.activo=1
                    order by op.curso, act.nombre";
        
        }elseif($prioridad->estado == 2){
            $sql = "SELECT comi.id AS idcomi, act.nombre AS actividad, op.curso AS curso, comi.nombre AS comision, op.resumen AS resumen, comi.horario AS horario, comi.aula AS aula 
                FROM `espaciocurricular` op
                left join comision comi ON comi.espaciocurricular = op.id
                left join actividad act ON op.actividad = act.id
                left join aniolectivo al2 on op.aniolectivo = al2.id
                WHERE op.curso in 
                (select curso from admisionoptativa ao left join aniolectivo al on ao.aniolectivo = al.id where alumno = ".$alumno." and al.activo=1)
                AND al2.activo=1
                    order by op.curso, act.nombre";
        }else{
            $sql = 1;
        }
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
