<?php

namespace app\modules\curriculares\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\curriculares\models\Seguimiento;
use yii\data\SqlDataProvider;

/**
 * SeguimientoSearch represents the model behind the search form of `app\modules\optativas\models\Seguimiento`.
 */
class SeguimientoSearch extends Seguimiento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'matricula', 'trimestre'], 'integer'],
            [['fecha', 'descripcion'], 'safe'],
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
        $query = Seguimiento::find();

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
            'fecha' => $this->fecha,
            'descripcion' => $this->descripcion,
        ]);

        return $dataProvider;
    }

    public function seguimientosdelalumno($id)
    {
        $query = Seguimiento::find()
                ->where(['matricula' => $id])
                ->orderBy('fecha DESC');

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
        $query->andFilterWhere([
            'id' => $this->id,
            'matricula' => $this->matricula,
            'fecha' => $this->fecha,
            'descripcion' => $this->descripcion,
        ]);

        return $dataProvider;
    }

    public function providerseguimientoxdivision($params, $tipoespacio)
    
    {
        

        $sql='SELECT di.nombre as division, al.apellido, al.nombre, ac.nombre as actividad, count(s.id) as seguimientos, mat.id as matricula
        FROM matricula mat
        left join seguimiento s ON s.matricula = mat.id
        left join comision com ON mat.comision = com.id
        left join espaciocurricular op ON com.espaciocurricular = op.id
        left join actividad ac ON op.actividad = ac.id

        left join alumno al ON mat.alumno = al.id
        left join division di ON mat.division = di.id
        WHERE op.tipoespacio = '.$tipoespacio;

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
