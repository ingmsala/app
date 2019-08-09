<?php

namespace app\modules\optativas\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\optativas\models\Inasistencia;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * InasistenciaSearch represents the model behind the search form of `app\modules\optativas\models\Inasistencia`.
 */
class InasistenciaSearch extends Inasistencia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'matricula', 'clase'], 'integer'],
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
        $query = Inasistencia::find();

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
            'matricula' => $this->matricula,
            'clase' => $this->clase,
        ]);

        return $dataProvider;
    }

    public function providerinasistenciasxalumno($id)
    {
        $query = Inasistencia::find()
                    ->joinWith(['clase0'])
                    ->where(['inasistencia.matricula' => $id])
                    ->orderBy('clase.fecha ASC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($id);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        

        return $dataProvider;
    }

    public function providerinasistenciasxdivision($params)
    
    {
        /*$sql='SELECT di.nombre as division, al.apellido, al.nombre, ac.nombre as actividad, count(i.id) as inasistencias,(
            SELECT SUM( c2.horascatedra ) 
                FROM clase c2
                LEFT JOIN comision com2 ON c2.comision = com2.id
                WHERE com2.id =com.id
        ) as horascatededra, sum(c.horascatedra) as horasfalta
        FROM matricula mat
        left join inasistencia i ON i.matricula = mat.id
        left join clase c ON i.clase = c.id
        left join comision com ON mat.comision = com.id
        left join optativa op ON com.optativa = op.id
        left join actividad ac ON op.actividad = ac.id

        left join alumno al ON mat.alumno = al.id
        left join division di ON mat.division = di.id
        WHERE true ';

        if (isset($params['Inasistencia']['division']) && $params['Inasistencia']['division'] != '') 
          $sql.=  ' AND mat.division='.$params['Inasistencia']['division'];

        if (isset($params['Inasistencia']['aniolectivo']) && $params['Inasistencia']['aniolectivo'] != '') 
          $sql.=  ' AND op.aniolectivo='.$params['Inasistencia']['aniolectivo'];
        */

        $sql='SELECT di.nombre as division, al.apellido, al.nombre, ac.nombre as actividad, count(i.id) as inasistencias, op.duracion as horascatededra, sum(c.horascatedra) as horasfalta
        FROM matricula mat
        left join inasistencia i ON i.matricula = mat.id
        left join clase c ON i.clase = c.id
        left join comision com ON mat.comision = com.id
        left join optativa op ON com.optativa = op.id
        left join actividad ac ON op.actividad = ac.id

        left join alumno al ON mat.alumno = al.id
        left join division di ON mat.division = di.id
        WHERE true ';

        if (isset($params['Inasistencia']['division']) && $params['Inasistencia']['division'] != '') 
          $sql.=  ' AND mat.division='.$params['Inasistencia']['division'];

        if (isset($params['Inasistencia']['aniolectivo']) && $params['Inasistencia']['aniolectivo'] != '') 
          $sql.=  ' AND op.aniolectivo='.$params['Inasistencia']['aniolectivo'];
        else
          $sql.=  ' AND op.aniolectivo=null';

        $sql.=' group by di.nombre, al.apellido, al.nombre, ac.nombre'; 
        $sql.=' order by di.nombre, al.apellido, al.nombre, ac.nombre'; 


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
