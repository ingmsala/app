<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\models\Detalleparte;
use app\config\Globales;

/**
 * DetalleparteSearch represents the model behind the search form of app\models\Detalleparte`.
 */
class DetalleparteSearch extends Detalleparte
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parte', 'division', 'agente', 'hora', 'llego', 'retiro', 'falta', 'estadoinasistencia','detalleadelrecup'], 'integer'],
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
    
    public function aux($params)
    {
        if(Yii::$app->user->identity->username == 'regenciatm'){
            $query = Detalleparte::find()->joinWith('division0')
            ->where(['estadoinasistencia' => Globales::ESTADOINASIST_PREC])
            ->orWhere(['estadoinasistencia' => Globales::ESTADOINASIST_REGREC])
            ->andWhere(['division.turno' =>Globales::TURNO_MAN]);
        }elseif(Yii::$app->user->identity->username == 'regenciatt'){
            $query = Detalleparte::find()->joinWith('division0')
            ->where(['estadoinasistencia' => Globales::ESTADOINASIST_PREC])
            ->orWhere(['estadoinasistencia' => Globales::ESTADOINASIST_REGREC])
            ->andWhere(['division.turno' =>Globales::TURNO_TAR]);
        }elseif(Yii::$app->user->identity->username == 'msala'){
            $query = Detalleparte::find()->joinWith('division0')
            ->where(['estadoinasistencia' => Globales::ESTADOINASIST_PREC])
            ->orWhere(['estadoinasistencia' => Globales::ESTADOINASIST_REGREC]);
            
        }
        

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
            'parte' => $this->parte,
            'division' => $this->division,
            'agente' => $this->agente,
            'hora' => $this->hora,
            'llego' => $this->llego,
            'retiro' => $this->retiro,
            'falta' => $this->falta,
            'detalleadelrecup' => $this->detalleadelrecup,
            'estadoinasistencia' => $this->estadoinasistencia,
        ]);

        return $dataProvider;
    }

    public function search($params)
    {
        if (isset($params['Detalleparte']['solodia']) && $params['Detalleparte']['solodia'] == 1){
            $sql= 'select distinct ' ;
        }else{
            $sql= 'select distinct detalleparte.id as id, division.nombre as division, hora.nombre as hora, ' ;
        }
        $sql.='
        parte.fecha as fecha, tiposemana.nombre as tipo, agente.apellido as apellido, agente.nombre as nombred, detalleparte.llego, detalleparte.retiro, falta.nombre as falta, estadoinasistenciaxparte.detalle as detalle, detalleparte.estadoinasistencia as estadoinasistenciax, esdp.nombre as estadoinasistenciaxtxt, (select count(*) from estadoinasistenciaxparte eixp where eixp.detalleparte = detalleparte.id) as cont 
        from detalleparte 
        left join division on detalleparte.division = division.id
        left join tiposemana on detalleparte.tipo = tiposemana.id
        left join agente on detalleparte.agente = agente.id
        left join estadoinasistencia esdp on detalleparte.estadoinasistencia = esdp.id
        left join hora on detalleparte.hora = hora.id
        left join falta on detalleparte.falta = falta.id
        left join parte on detalleparte.parte = parte.id 
        left join estadoinasistenciaxparte on detalleparte.id = estadoinasistenciaxparte.detalleparte 
        left join estadoinasistencia on estadoinasistencia.id = estadoinasistenciaxparte.estadoinasistencia
        left join falta f on estadoinasistenciaxparte.falta = f.id 
        where estadoinasistenciaxparte.id = (select max(eixp2.id) from estadoinasistenciaxparte eixp2 where eixp2.detalleparte = detalleparte.id)';

        if (isset($params['Detalleparte']['anio']) && $params['Detalleparte']['anio'] != ''){
            $sql .= ' and year(parte.fecha) = '.$params["Detalleparte"]["anio"];
        }
        if (isset($params['Detalleparte']['mes']) && $params['Detalleparte']['mes'] != ''){
            $sql .= ' and month(parte.fecha) = '.$params["Detalleparte"]["mes"];
        }
        if (isset($params['Detalleparte']['agente']) && $params['Detalleparte']['agente'] != ''){
            $sql .= ' and detalleparte.agente = '.$params["Detalleparte"]["agente"];
        }
        if (isset($params['Detalleparte']['estadoinasistencia']) && $params['Detalleparte']['estadoinasistencia'] != ''){
            $sql .= ' and detalleparte.estadoinasistencia = '.$params["Detalleparte"]["estadoinasistencia"];
        }else{
            if ( in_array (Yii::$app->user->identity->role, [Globales::US_REGENCIA])) {
                $sql .= ' and (detalleparte.estadoinasistencia=1 or detalleparte.estadoinasistencia=3)';
            }elseif( in_array (Yii::$app->user->identity->role, [Globales::US_SACADEMICA])){
                $sql .= ' and (detalleparte.estadoinasistencia=1 or detalleparte.estadoinasistencia=7)';
                $sql .= ' and parte.preceptoria=7';
            }else{
             $sql .= ' and detalleparte.estadoinasistencia=2';   
            }

        }
        if ( in_array (Yii::$app->user->identity->role, [Globales::US_REGENCIA])) {
            
            if (Yii::$app->user->identity->username == 'regenciatm'){
                $sql .= ' and division.turno=1';
            }elseif(Yii::$app->user->identity->username == 'regenciatt'){
                $sql .= ' and division.turno=2';
            }else{
                $sql .= ' and (division.turno=1 or division.turno=2)';//regencia unificada
            }
            
        }

        if ( in_array (Yii::$app->user->identity->role, [Globales::US_SACADEMICA])) {
           
                $sql .= ' and division.turno=4';
            
            
        }

        if (isset($params['Detalleparte']['solodia']) && $params['Detalleparte']['solodia'] == 1){
            $sql.= ' order by parte.fecha desc, agente.apellido, agente.nombre';
        }else{
            $sql.= ' order by parte.fecha desc, division.nombre, hora.nombre';
        }
       
        


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

       

        // grid filtering conditions
        

        return $dataProvider;

    }

    public function otrasausencias($id, $fecha)
    {
        
            $query = Detalleparte::find()
            ->distinct()
            ->select(['agente'])
            ->joinWith(['agente0', 'division0', 'parte0', 'division0.turno0'])
            ->where(['parte.fecha' => $fecha])
            ->andWhere(['<>', 'detalleparte.parte', $id])
            ->andWhere(['detalleparte.falta' => 1])
            ->orderBy('agente.apellido, agente.nombre');
       
        

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
            'parte' => $this->parte,
            'division' => $this->division,
            'agente' => $this->agente,
            'hora' => $this->hora,
            'llego' => $this->llego,
            'retiro' => $this->retiro,
            'falta' => $this->falta,
            'estadoinasistencia' => $this->estadoinasistencia,
        ]);

        return $dataProvider;
    }

    public function search2($params)
    {
        $query = Detalleparte::find()
            ->where(['estadoinasistencia' => 2])
            ->andWhere(['!=', 'falta', 2]);

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
            'parte' => $this->parte,
            'division' => $this->division,
            'agente' => $this->agente,
            'hora' => $this->hora,
            'llego' => $this->llego,
            'retiro' => $this->retiro,
            'falta' => $this->falta,
            'estadoinasistencia' => $this->estadoinasistencia,
        ]);

        return $dataProvider;
    }

    public function providerxparte($id)
    {
        $query = Detalleparte::find()
            ->where(['parte' => $id,
                //'condicion' => 5 //suplente
            ])->joinWith(['estadoinasistencias',])
            ->orderBy('division, hora');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }

    public function providerxdocente($id)
    {
        $query = Detalleparte::find()
            ->where(['agente' => $id,
                //'condicion' => 5 //suplente
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }

    public function providerxmes($mes, $anio)
    {
        /*$query = Detalleparte::find()
            ->select('COUNT( detalleparte.falta ) AS falta, parte.fecha')
            ->joinWith(['parte0'])
            ->where(['month(parte.fecha)' => $mes,
                'detalleparte.falta' => 1 //suplente
            ])
            ->groupBy('parte.fecha');*/

        $sql='SELECT p.fecha, COUNT( dp.falta ) AS faltas
            FROM parte p
            INNER JOIN detalleparte dp ON dp.parte = p.id
            WHERE dp.falta =1
            AND MONTH( p.fecha ) ='.$mes.'
            AND YEAR( p.fecha ) ='.$anio.'
            GROUP BY p.fecha';


        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }

    public function providerxanio($anio)
    {
        
        $sql='
            SELECT MONTH(p.fecha) as meses, COUNT( dp.falta ) AS faltas, COUNT( DISTINCT  p.fecha ) AS diasclase
            FROM parte p
            INNER JOIN detalleparte dp ON dp.parte = p.id
            WHERE (dp.falta =1 OR dp.falta =2)
            AND YEAR( p.fecha ) ='.$anio.'
            GROUP BY MONTH(p.fecha)';


        $dataProvider = new SqlDataProvider([
            
            'sql' => $sql,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }

    public function providerxanioxturno($anio)
    {
        
        $sql='
        SELECT MONTH(p1.fecha) as meses, (
            SELECT
            COUNT( dp2.falta )
            FROM parte p2
            INNER JOIN detalleparte dp2 ON dp2.parte = p2.id
                INNER JOIN preceptoria pr2 ON p2.preceptoria = pr2.id
            WHERE dp2.falta = 1
            AND pr2.turno = 1
            AND YEAR( p2.fecha ) = '.$anio.'
            AND MONTH(p1.fecha) = MONTH(p2.fecha)
        
        
        ) as manana,
        (
            SELECT
            COUNT( dp3.falta )
            FROM parte p3
            INNER JOIN detalleparte dp3 ON dp3.parte = p3.id
                INNER JOIN preceptoria pr3 ON p3.preceptoria = pr3.id
            WHERE dp3.falta = 1
            AND pr3.turno = 2
            AND YEAR( p3.fecha ) = '.$anio.'
            AND MONTH(p1.fecha) = MONTH(p3.fecha)
        ) as tarde
        
        FROM parte p1
        LEFT JOIN detalleparte dp1 ON dp1.parte = p1.id
        LEFT JOIN preceptoria pr1 ON p1.preceptoria = pr1.id
        WHERE dp1.falta = 1
        AND YEAR( p1.fecha ) = '.$anio.'
        GROUP BY MONTH(p1.fecha)
        ';


        $dataProvider = new SqlDataProvider([
            
            'sql' => $sql,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }

    public function providerxanioxturnototal($anio)
    {
        
        $sql='
        SELECT YEAR(p1.fecha) as anio, (
      select
        COUNT( dp2.falta )
        FROM parte p2
        INNER JOIN detalleparte dp2 ON dp2.parte = p2.id
            INNER JOIN preceptoria pr2 ON p2.preceptoria = pr2.id
        WHERE dp2.falta = 1
        AND pr2.turno = 1
        AND YEAR( p2.fecha ) = '.$anio.'
        AND YEAR(p1.fecha) = YEAR(p2.fecha)
        
        
        
      ) as manana,
      (
      select
        COUNT( dp3.falta )
        FROM parte p3
        INNER JOIN detalleparte dp3 ON dp3.parte = p3.id
            INNER JOIN preceptoria pr3 ON p3.preceptoria = pr3.id
        WHERE dp3.falta = 1
        AND pr3.turno = 2
        AND YEAR( p3.fecha ) = '.$anio.'
        AND YEAR(p1.fecha) = YEAR(p3.fecha)
        
        
      ) as tarde
        FROM parte p1
        LEFT JOIN detalleparte dp1 ON dp1.parte = p1.id
        LEFT JOIN preceptoria pr1 ON p1.preceptoria = pr1.id
        WHERE dp1.falta = 1
        AND YEAR( p1.fecha ) = '.$anio.'
        GROUP BY YEAR(p1.fecha)
        ';


        $dataProvider = new SqlDataProvider([
            
            'sql' => $sql,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }


    public function providerdistribuciondediasxmes($mes, $anio)
    {
        
        $sql='
             SELECT  
              CASE 
                WHEN day(p.fecha) <= 5 THEN "1-5" 
                WHEN day(p.fecha) <= 10 THEN "6-10" 
                WHEN day(p.fecha) <= 15 THEN "11-15" 
                WHEN day(p.fecha) <= 20 THEN "16-20"
                WHEN day(p.fecha) <= 25 THEN "21-25"
                WHEN day(p.fecha) <= 31 THEN "26-31"
                
              END 
            as rango, count(dp.falta) as faltas
            FROM parte p
            INNER JOIN detalleparte dp ON dp.parte = p.id
            INNER JOIN preceptoria pr ON p.preceptoria = pr.id
            WHERE dp.falta = 1
            AND YEAR( p.fecha ) = '.$anio;

        ($mes != 0) ? 
        $sql.= ' AND MONTH( p.fecha ) = '.$mes : '';
        $sql.=' GROUP BY rango
            order by day( p.fecha )';

        $dataProvider = new SqlDataProvider([
            
            'sql' => $sql,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }

    public function providerdistribuciondediasyhoras($mes, $anio, $turno)
    {
        
        $sql='
             SELECT  
                WEEKDAY(p.fecha) dia, dp.hora-1 as horas, count(dp.falta) as faltas
                FROM parte p
                INNER JOIN detalleparte dp ON dp.parte = p.id
                INNER JOIN preceptoria pr ON p.preceptoria = pr.id
                WHERE dp.falta = 1
                AND YEAR( p.fecha ) = '.$anio.'
               
        ';

        ($mes != 0) ? 
        $sql.= ' AND MONTH( p.fecha ) = '.$mes : '';
        ($turno != 0) ? 
        $sql.= ' AND pr.turno = '.$turno : '';

        $sql.= ' GROUP BY WEEKDAY(p.fecha), horas
                order by WEEKDAY(p.fecha)';



        $dataProvider = new SqlDataProvider([
            
            'sql' => $sql,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }


    public function providerfaltasdocentes($mes, $anio, $agente)
    {
        
        $sql='
            SELECT d.id, d.legajo, d.apellido, d.nombre, 
            SUM(
            CASE
              WHEN dp.falta <= 2 THEN 40 
              WHEN dp.falta = 3 THEN (coalesce(dp.retiro,0) + coalesce(dp.llego,0))
              WHEN dp.falta = 4 THEN -40 
              WHEN dp.falta = 6 THEN -40
              WHEN dp.falta = 7 THEN -40
            END) AS faltas
            FROM detalleparte dp
            LEFT JOIN agente d  ON dp.agente = d.id
            LEFT JOIN parte p ON dp.parte = p.id
            WHERE true ';
        ($anio != 0) ? 
            $sql.= ' AND YEAR( p.fecha ) = '.$anio : '';
        ($mes != 0) ? 
            $sql.= ' AND MONTH( p.fecha ) = '.$mes : '';
        ($agente != 0) ? 
            $sql.= ' AND d.id = '.$agente : '';
        $sql.=' GROUP BY d.legajo, d.apellido, d.nombre
               ORDER BY faltas DESC, d.apellido, d.nombre, d.legajo';

        $dataProvider = new SqlDataProvider([
            
            'sql' => $sql,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }

    public function     providerfaltasdocentesview($mes, $anio, $id)
    {
        
        $sql='
            SELECT p.fecha, di.nombre as division, h.nombre as hora, dp.llego, dp.retiro, f.nombre as falta, ei.nombre as estadoinasistencia
            FROM detalleparte dp
            LEFT JOIN parte p ON dp.parte = p.id
            LEFT JOIN hora h ON dp.hora = h.id
            LEFT JOIN division di ON dp.division = di.id
            LEFT JOIN falta f ON dp.falta = f.id
            LEFT JOIN estadoinasistencia ei ON dp.estadoinasistencia = ei.id
            WHERE YEAR(p.fecha) = '.$anio.'
            AND dp.agente = '.$id;
            
            

        ($mes != 0) ? 
        $sql.= ' AND MONTH( p.fecha ) = '.$mes : '';
        $sql.=' ORDER BY p.fecha, dp.division, dp.hora';

        $dataProvider = new SqlDataProvider([
            
            'sql' => $sql,
            'pagination' => false
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }

    public function providerfaltasxdivision($mes, $anio)
    {
        
        $sql='
                select d.nombre as division, count(*) as faltas
                FROM detalleparte dp
                LEFT JOIN parte p ON dp.parte=p.id
                LEFT JOIN division d ON dp.division=d.id
                WHERE (dp.falta = 1 or dp.falta = 2)
                AND YEAR( p.fecha ) = '.$anio;

        ($mes != 0) ? 
        $sql.= ' AND MONTH( p.fecha ) = '.$mes : '';
        $sql.=' GROUP BY division
        ORDER BY faltas DESC';

        $dataProvider = new SqlDataProvider([
            
            'sql' => $sql,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }

    public function estadoinasistenciaXdocente($mes, $anio, $agente)
    {
        $query = 'SELECT
    `agente`.`id` AS `agente`,
    `agente`.`apellido`,
    `agente`.`nombre`,
    (
    SELECT
        COUNT(dp2.estadoinasistencia)
    FROM
        detalleparte dp2
    WHERE
        dp2.agente = detalleparte.agente AND dp2.estadoinasistencia = 4 AND(dp2.`falta` IN(1, 2)) AND(
            `detalleparte`.`agente` IS NOT NULL
        ) AND(YEAR(parte.fecha) = '.$anio.')
) AS estadoinasistencia,
(
    (
    SELECT
        COUNT(dp.id)
    FROM
        detalleparte AS dp
    WHERE
        dp.agente = detalleparte.agente AND(dp.falta = 1 OR dp.falta = 2) AND(YEAR(parte.fecha) = '.$anio.')
) -(
    SELECT
        COUNT(dp.id)
    FROM
        detalleparte AS dp
    WHERE
        dp.agente = detalleparte.agente AND(
            dp.falta = 4 OR dp.falta = 6 OR dp.falta = 7
        ) AND(YEAR(parte.fecha) = '.$anio.')
)
) AS id
FROM
    `detalleparte`
LEFT JOIN `agente` ON `detalleparte`.`agente` = `agente`.`id`
LEFT JOIN `parte` ON `detalleparte`.`parte` = `parte`.`id`
WHERE
    (`falta` IN(1, 2)) AND(
        `detalleparte`.`agente` IS NOT NULL
    ) AND(YEAR(parte.fecha) = '.$anio.')
GROUP BY
    `agente`.`id`,
    `agente`.`apellido`,
    `agente`.`nombre`
ORDER BY
    (
        (
        SELECT
            COUNT(dp.id)
        FROM
            detalleparte AS dp
        WHERE
            dp.agente = detalleparte.agente AND(
                dp.falta = 1 OR dp.falta = 2 OR dp.falta = 3
            )
    ) -(
    SELECT
        COUNT(dp.id)
    FROM
        detalleparte AS dp
    WHERE
        dp.agente = detalleparte.agente AND(
            dp.falta = 4 OR dp.falta = 6 OR dp.falta = 7
        )
)
    )
DESC';

        // add conditions that should always apply here

        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            //'pagination' => false
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
