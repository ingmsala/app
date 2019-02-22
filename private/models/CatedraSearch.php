<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Catedra;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * CatedraSearch represents the model behind the search form of `app\models\Catedra`.
 */
class CatedraSearch extends Catedra
{
    public $actividad;
    public $division;
    public $docentes;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', ], 'integer'],
            [['division', 'actividad', 'docentes'], 'safe'],
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
        $query = Catedra::find()
            ->joinWith(['actividad0', 'division0', 'detallecatedras', 'detallecatedras.docente0'])
            ->orderBy('division.nombre, actividad.nombre');

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

        $dataProvider->sort->attributes['actividad0'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['actividad.nombre' => SORT_ASC],
        'desc' => ['actividad.nombre' => SORT_DESC],
        ];
        // Lets do the same with country now
        $dataProvider->sort->attributes['division0'] = [
        'asc' => ['division.nombre' => SORT_ASC],
        'desc' => ['division.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['docentes'] = [
        'asc' => ['docente.apellido' => SORT_ASC],
        'desc' => ['docente.apellido' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'catedra.id' => $this->id,
            
        ]);

        $query->andFilterWhere(['like', 'actividad.nombre', $this->actividad])
        ->andFilterWhere(['like', 'division.nombre', $this->division])
        ->andFilterWhere(['like', 'docente.apellido', $this->docentes]);
        return $dataProvider;
    }

    public function providercatedras($params)
    {
        
        $sql='
        select c.id as id, a.nombre as actividad, dc.hora as hora, d.nombre as division, concat(doc.apellido,", ",doc.nombre) as docente, con.nombre as condicion, rev.nombre as revista, pro.nombre as propuesta, dc.activo
        from catedra c
        left join detallecatedra dc ON c.id = dc.catedra
        left join actividad a ON a.id = c.actividad
        left join division d ON d.id = c.division
        left join docente doc ON dc.docente = doc.id
        left join condicion con ON dc.condicion = con.id
        left join revista rev ON dc.revista = rev.id
        left join propuesta pro ON a.propuesta = pro.id
        where (dc.activo is null or dc.activo=1 or dc.activo=2)';
        if (isset($params['division'])){
            $sql .= ' AND d.nombre like "%'.$params["division"].'%"';
        }
        if (isset($params['actividad'])){
            $sql .= ' AND a.nombre like "%'.$params["actividad"].'%"';
        }
        if (isset($params['docente'])){
            $sql .= ' AND doc.apellido like "%'.$params["docente"].'%"';
        }
        if (isset($params['propuesta'])){
            $sql .= ' AND a.propuesta like "%'.$params["propuesta"].'%"';
        }
        $sql.= ' order by a.propuesta, division, a.nombre, rev.nombre';


        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
            'sort' => [
                'attributes' => [
                    'actividad',
                    'division' => [
                        'asc' => ['division' => SORT_ASC, 'division' => SORT_ASC],
                        'desc' => ['division' => SORT_DESC, 'division' => SORT_DESC],
                        
                    ],
                    'docente' => [
                        'asc' => ['docente' => SORT_ASC, 'docente' => SORT_ASC],
                        'desc' => ['docente' => SORT_DESC, 'docente' => SORT_DESC],
                        
                    ],
                ],
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        $dataProvider->sort->attributes['actividad'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['actividad' => SORT_ASC],
        'desc' => ['actividad' => SORT_DESC],
        ];
        // Lets do the same with country now
        $dataProvider->sort->attributes['division'] = [
        'asc' => ['division' => SORT_ASC],
        'desc' => ['division' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['docente'] = [
        'asc' => ['docente' => SORT_ASC],
        'desc' => ['docente' => SORT_DESC],
        ];

        // grid filtering conditions
        

        return $dataProvider;

    }
    


}
