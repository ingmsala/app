<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\models\Detalleparte;

/**
 * DetalleparteSearch represents the model behind the search form of `app\models\Detalleparte`.
 */
class DetalleparteSearch extends Detalleparte
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parte', 'division', 'docente', 'hora', 'llego', 'retiro', 'falta'], 'integer'],
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
        $query = Detalleparte::find();

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
            'docente' => $this->docente,
            'hora' => $this->hora,
            'llego' => $this->llego,
            'retiro' => $this->retiro,
            'falta' => $this->falta,
        ]);

        return $dataProvider;
    }

    public function providerxparte($id)
    {
        $query = Detalleparte::find()
            ->where(['parte' => $id,
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

    public function providerxdocente($id)
    {
        $query = Detalleparte::find()
            ->where(['docente' => $id,
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
            SELECT MONTH(p.fecha) as meses, COUNT( dp.falta ) AS faltas
            FROM parte p
            INNER JOIN detalleparte dp ON dp.parte = p.id
            WHERE dp.falta =1
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
            AND YEAR( p.fecha ) = '.$anio.'
            AND MONTH( p.fecha ) = '.$mes.'
            GROUP BY rango
            order by day( p.fecha )
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

    
}
