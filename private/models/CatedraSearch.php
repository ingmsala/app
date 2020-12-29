<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Catedra;
use yii\data\SqlDataProvider;
use yii\db\Query;
use app\config\Globales;
use app\modules\curriculares\models\Aniolectivo;

/**
 * CatedraSearch represents the model behind the search form of app\models\Catedra.
 */
class CatedraSearch extends Catedra
{
    public $actividad;
    public $division;
    public $agentes;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', ], 'integer'],
            [['division', 'actividad', 'agentes'], 'safe'],
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
            ->joinWith(['actividad0', 'division0', 'detallecatedras', 'detallecatedras.agente0', 'actividad0.propuesta0'])
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

        $dataProvider->sort->attributes['agentes'] = [
        'asc' => ['agente.apellido' => SORT_ASC],
        'desc' => ['agente.apellido' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['actividad0.propuesta0'] = [
        'asc' => ['propuesta.nombre' => SORT_ASC],
        'desc' => ['propuesta.nombre' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'catedra.id' => $this->id,
            
        ]);

        $query->andFilterWhere(['like', 'actividad.nombre', $this->actividad])
        ->andFilterWhere(['like', 'division.nombre', $this->division])
        ->andFilterWhere(['like', 'agente.apellido', $this->agentes]);
        return $dataProvider;
    }

    public function providercatedras($params)
    {
        
        $sql='
        select c.id as id, a.nombre as actividad, a.cantHoras as horaact, dc.hora as hora, d.nombre as division, concat(doc.apellido,", ",doc.nombre) as agente, con.nombre as condicion, rev.nombre as revista, pro.nombre as propuesta, dc.activo
        from catedra c
        left join detallecatedra dc ON c.id = dc.catedra
        left join actividad a ON a.id = c.actividad
        left join division d ON d.id = c.division
        left join agente doc ON dc.agente = doc.id
        left join condicion con ON dc.condicion = con.id
        left join revista rev ON dc.revista = rev.id
        left join propuesta pro ON a.propuesta = pro.id
        where dc.condicion <> 6';
        if (!isset($params['Catedra']['activo']) or $params['Catedra']['activo'] == 0){
            $sql .= ' AND (dc.activo is null or dc.activo='.Globales::DETCAT_ACTIVO.')';
        }else{
            $sql .= ' AND (dc.activo='.Globales::DETCAT_INACTIVO.')';
            $sql .= ' AND c.id not in (select c2.id from catedra c2 left join detallecatedra dc2 ON c2.id = dc2.catedra where dc2.activo=null or dc2.activo=1)';
        }
        if (isset($params['Catedra']['divisionnom']) && $params['Catedra']['divisionnom'] != ''){
            $sql .= ' AND d.nombre like "%'.$params['Catedra']["divisionnom"].'%"';
        }
        if (isset($params['Catedra']['resolucion']) && $params['Catedra']['resolucion'] != ''){
            $sql .= ' AND dc.resolucion like "%'.$params["Catedra"]['resolucion'].'%"';
        }
        if (isset($params['Catedra']['actividadnom']) && $params['Catedra']['actividadnom'] != ''){
            $sql .= ' AND a.nombre like "%'.$params["Catedra"]['actividadnom'].'%"';
        }
        if (isset($params['Catedra']['agente']) && $params['Catedra']['agente'] != ''){
            $sql .= ' AND doc.id = '.$params['Catedra']['agente'];
        }
        if (isset($params['Catedra']['condicion']) && $params['Catedra']['condicion'] != ''){
            $sql .= ' AND dc.condicion = '.$params['Catedra']['condicion'];
        }
        if (isset($params['Catedra']['propuesta']) && $params['Catedra']['propuesta'] != ''){
            $sql .= ' AND a.propuesta ='.$params['Catedra']["propuesta"];
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
                    'agente' => [
                        'asc' => ['agente' => SORT_ASC, 'agente' => SORT_ASC],
                        'desc' => ['agente' => SORT_DESC, 'agente' => SORT_DESC],
                        
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

        $dataProvider->sort->attributes['agente'] = [
        'asc' => ['agente' => SORT_ASC],
        'desc' => ['agente' => SORT_DESC],
        ];

        // grid filtering conditions
        

        return $dataProvider;

    }

    public function vigenterepetido(){
        $sql = 'SELECT
        count(distinct(concat(doc.apellido, ", ", doc.nombre))) as cantidad, c.id as catedra, acti.nombre as actividad, divi.nombre as division
        FROM
        catedra c
        LEFT JOIN detallecatedra dc ON
        dc.catedra = c.id
        LEFT JOIN actividad acti ON
        c.actividad = acti.id
        LEFT JOIN agente doc ON
        dc.agente = doc.id
        LEFT JOIN division divi ON
        c.division = divi.id
        WHERE
        dc.revista = 1 AND dc.activo = 1
        AND
        divi.turno in (1,2) 
        AND
        (select count(dc20.id) from detallecatedra dc20
            LEFT JOIN catedra c2 ON dc20.catedra = c2.id
            LEFT JOIN division divi2 ON c2.division = divi2.id
            where divi2.turno in (1,2) 
            and dc20.revista = 6 AND dc20.activo = 1) > 0
        group by c.id  
        having count(distinct(concat(doc.apellido, ", ", doc.nombre)))>1';

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
            
        ]);

        if (!$this->validate()) {
           return $dataProvider;
        }



        return $dataProvider;


    }


    public function diferenciacatedras()
    {

        $al = Aniolectivo::find()->where(['activo' => 1])->one()->id;
        
        $sql='SELECT c0.id, di.nombre as division, act.nombre as actividad, (
    SELECT 
        distinct(concat(doc.apellido, ", ", doc.nombre))
    FROM
        catedra c
    LEFT JOIN detallecatedra dc ON
        dc.catedra = c.id
    LEFT JOIN agente doc ON
        dc.agente = doc.id
    WHERE
        dc.revista = 1 AND dc.activo = 1 AND c.id = c0.id
    AND
        (select count(dc20.id) from detallecatedra dc20 where dc20.catedra = c0.id AND dc20.activo = 1 AND dc20.aniolectivo = '.$al.') > 0
) as vigente, 

(
    SELECT 
        
        distinct(concat(doc2.apellido, ", ", doc2.nombre))
    FROM
        catedra c2
    LEFT JOIN detallecatedra dc2 ON
        dc2.catedra = c2.id
    LEFT JOIN agente doc2 ON
        dc2.agente = doc2.id
    WHERE
        dc2.revista = 6 AND dc2.activo = 1 AND c2.id = c0.id AND dc2.aniolectivo = '.$al.' 
) as horario
    
FROM
    catedra c0
left join division di ON c0.division = di.id
left join actividad act ON c0.actividad = act.id
where (
    SELECT 
        distinct(doc.id)
    FROM
        catedra c
    LEFT JOIN detallecatedra dc ON
        dc.catedra = c.id
    LEFT JOIN agente doc ON
        dc.agente = doc.id
    WHERE
        dc.revista = 1 AND dc.activo = 1 AND c.id = c0.id AND (select count(dc20.id) from detallecatedra dc20 where dc20.catedra = c0.id and dc20.revista = 6 AND dc20.activo = 1 AND dc20.aniolectivo = '.$al.' ) > 0
) not in
(
    SELECT 
        
        DISTINCT(doc2.id)
    FROM
        catedra c2
    LEFT JOIN detallecatedra dc2 ON
        dc2.catedra = c2.id
    LEFT JOIN agente doc2 ON
        dc2.agente = doc2.id
    WHERE
        dc2.revista = 6 AND dc2.activo = 1 AND c2.id = c0.id AND dc2.aniolectivo = '.$al.' 
) 
and (di.turno = 1 or di.turno = 2) and (act.id <> 23) and (di.id <> 47)
ORDER BY
    act.nombre, di.id';


        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
            
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        // grid filtering conditions
        

        return $dataProvider;

    }


    public function diferenciacatedrasyhoras()
    {
        
        $sql='SELECT ac.id as actid, ac.nombre as materia, di.id as divid, di.nombre as division, ac.cantHoras as horasmat, count(h.id) as horashorario 
        FROM `catedra` c 
        left join horario h ON h.catedra = c.id
        left join actividad ac ON c.actividad = ac.id
        left join division di ON c.division = di.id
        left join aniolectivo al ON al.id = h.aniolectivo
        where (di.turno = 1 or di.turno = 2) and (ac.id <> 23) and (ac.id <> 31) and (ac.id <> 33) and (al.activo = 1)
        group by ac.id, ac.nombre, di.id, di.nombre, ac.cantHoras 
        having ac.cantHoras <> count(h.id)
        ORDER BY `c`.`id` ASC';


        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
            
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        // grid filtering conditions
        

        return $dataProvider;

    }
    


}
