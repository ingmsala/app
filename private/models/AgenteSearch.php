<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Agente;
use yii\data\SqlDataProvider;
use yii\db\Query;
use app\config\Globales;

/**
 * AgenteSearch represents the model behind the search form of `app\models\Agente`.
 */
class AgenteSearch extends Agente
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipodocumento', 'localidad', 'mapuche'], 'integer'],
            [['legajo', 'apellido', 'nombre', 'genero', 'documento', 'mail', 'fechanac', 'telefono', 'cuil', 'domicilio'], 'safe'],
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

    public function search2($params)
    {
        $query = Agente::find()
            ->joinWith(['genero0'])
            ->orderBy('apellido', 'nombre', 'legajo')->indexBy('id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->sort->attributes['genero0'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['genero.nombre' => SORT_ASC],
        'desc' => ['genero.nombre' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            
        ]);

        $query->andFilterWhere(['like', 'legajo', $this->legajo])
            ->andFilterWhere(['or', 
                ['like', 'apellido', $this->apellido], 
                ['like', 'agente.nombre', $this->apellido]
            ])
            ->andFilterWhere(['like', 'apellido', $this->nombre])
            ->andFilterWhere(['like', 'genero.nombre', $this->genero])
            ->andFilterWhere(['like', 'documento', $this->documento]);

        return $dataProvider;
    }


    public function direccionesdesactualizadas($params)
    {
        $query = Agente::find()
            ->where(['mapuche' => 2])
            ->orderBy('apellido', 'nombre', 'legajo')->indexBy('id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'legajo', $this->legajo])
            ->andFilterWhere(['or', 
                ['like', 'apellido', $this->apellido], 
                ['like', 'agente.nombre', $this->apellido]
            ])
            ->andFilterWhere(['like', 'apellido', $this->nombre])
            ->andFilterWhere(['like', 'documento', $this->documento]);

        return $dataProvider;
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
        $query = Agente::find()
            ->joinWith(['genero0', 'detallepartes'])
            ->orderBy('apellido', 'nombre', 'legajo');

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

        $dataProvider->sort->attributes['genero0'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['genero.nombre' => SORT_ASC],
        'desc' => ['genero.nombre' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            
        ]);

        $query->andFilterWhere(['like', 'legajo', $this->legajo])
            ->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'agente.nombre', $this->nombre])
            ->andFilterWhere(['like', 'genero.nombre', $this->genero]);

        return $dataProvider;
    }


    public function detallehoras($id)
    {
        $query = Agente::find()
            ->where(['id' => $id]);

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
            'genero' => $this->genero,
        ]);

        $query->andFilterWhere(['like', 'legajo', $this->legajo])
            ->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }

    public function getPadronsumarizado()
        {
        
            $sql='select d.legajo, d.documento, d.apellido, d.nombre, (
    select count(distinct d2.id) from agente d2
    inner join detallecatedra dc2 ON dc2.agente = d2.id
    inner join catedra c2 ON dc2.catedra = c2.id
    inner join division di2 ON c2.division = di2.id
    where d2.id = d.id and dc2.activo=1 and di2.propuesta=1
    ) as docente_secundario,
    (
    select count(distinct d3.id) from agente d3
    inner join detallecatedra dc3 ON dc3.agente = d3.id
    inner join catedra c3 ON dc3.catedra = c3.id
    inner join division di3 ON c3.division = di3.id
    where d3.id = d.id and dc3.activo=1 and di3.propuesta=2
    ) as docente_pregrado,
    (
    select count(d4.id) from agente d4
    left join nombramiento n4 ON d4.id = n4.agente
    left join division di4 ON n4.division = di4.id
    where d4.id = d.id and n4.cargo=227 and (di4.propuesta=1 or n4.division is null)
    ) as preceptor_secundario, 
    (
    select count(d5.id) from agente d5
    inner join nombramiento n5 ON n5.agente = d5.id
    inner join division di5 ON n5.division = di5.id
    where d5.id = d.id and n5.cargo=227 and di5.propuesta=2
    ) as preceptor_pregrado,
    (
    select count(d6.id) from agente d6
    left join nombramiento n6 ON d6.id = n6.agente
    left join division di6 ON n6.division = di6.id
    where d6.id = d.id and n6.cargo=223 and (di6.propuesta=1 or n6.division is null)
    ) as jefe_secundario, 
    (
    select count(d7.id) from agente d7
    inner join nombramiento n7 ON n7.agente = d7.id
    inner join division di7 ON n7.division = di7.id
    where d7.id = d.id and n7.cargo=223 and di7.propuesta=2
    ) as jefe_pregrado,
    (
    select count(d8.id) from agente d8
    left join nombramiento n8 ON d8.id = n8.agente
    left join division di8 ON n8.division = di8.id
    where d8.id = d.id and n8.cargo IN (203, 205, 207, 209, 219, 226, 234, 241, 242) and (di8.propuesta=1 or n8.division is null)
    ) as otros_secundario, 
    (
    select count(d9.id) from agente d9
    inner join nombramiento n9 ON n9.agente = d9.id
    inner join division di9 ON n9.division = di9.id
    where d9.id = d.id and n9.cargo IN (203, 205, 207, 209, 219, 226, 234, 241, 242) and di9.propuesta=2
    ) as otros_pregrado, 
    ((select count(distinct d2.id) from agente d2
    inner join detallecatedra dc2 ON dc2.agente = d2.id
    inner join catedra c2 ON dc2.catedra = c2.id
    inner join division di2 ON c2.division = di2.id
    where d2.id = d.id and dc2.activo=1 and di2.propuesta=1) + (
    select count(distinct d3.id) from agente d3
    inner join detallecatedra dc3 ON dc3.agente = d3.id
    inner join catedra c3 ON dc3.catedra = c3.id
    inner join division di3 ON c3.division = di3.id
    where d3.id = d.id and dc3.activo=1 and di3.propuesta=2
    ) + (
    select count(d4.id) from agente d4
    left join nombramiento n4 ON d4.id = n4.agente
    left join division di4 ON n4.division = di4.id
    where d4.id = d.id and n4.cargo=227 and (di4.propuesta=1 or n4.division is null)
    ) + (
    select count(d5.id) from agente d5
    inner join nombramiento n5 ON n5.agente = d5.id
    inner join division di5 ON n5.division = di5.id
    where d5.id = d.id and n5.cargo=227 and di5.propuesta=2
    ) + (
    select count(d6.id) from agente d6
    left join nombramiento n6 ON d6.id = n6.agente
    left join division di6 ON n6.division = di6.id
    where d6.id = d.id and n6.cargo=223 and (di6.propuesta=1 or n6.division is null)
    ) + (
    select count(d7.id) from agente d7
    inner join nombramiento n7 ON n7.agente = d7.id
    inner join division di7 ON n7.division = di7.id
    where d7.id = d.id and n7.cargo=223 and di7.propuesta=2
    ) + (
    select count(d8.id) from agente d8
    left join nombramiento n8 ON d8.id = n8.agente
    left join division di8 ON n8.division = di8.id
    where d8.id = d.id and n8.cargo IN (203, 205, 207, 209, 219, 226, 234, 241, 242) and (di8.propuesta=1 or n8.division is null)
    ) + (
    select count(d9.id) from agente d9
    inner join nombramiento n9 ON n9.agente = d9.id
    inner join division di9 ON n9.division = di9.id
    where d9.id = d.id and n9.cargo IN (203, 205, 207, 209, 219, 226, 234, 241, 242) and di9.propuesta=2
    )) as total
    
    
from agente d
having total>0
order by d.apellido, d.nombre'; 


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
