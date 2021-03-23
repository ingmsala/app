<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Horarioexamen;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * HorarioexamenSearch represents the model behind the search form of `app\models\Horarioexamen`.
 */
class HorarioexamenSearch extends Horarioexamen
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'catedra', 'hora', 'tipo', 'anioxtrimestral', 'cambiada'], 'integer'],
            [['fecha'], 'safe'],
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
    public function search($id)
    {
        $query = Horarioexamen::find()->joinWith(['catedra0', 'catedra0.division0'])->where(['anioxtrimestral' => $id])->orderBy('division.id, horarioexamen.fecha, horarioexamen.hora');

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
            'catedra' => $this->catedra,
            'hora' => $this->hora,
            'tipo' => $this->tipo,
            'anioxtrimestral' => $this->anioxtrimestral,
            'fecha' => $this->fecha,
            'cambiada' => $this->cambiada,
        ]);

        return $dataProvider;
    }

    public function getSuperposicionCursos($id)
    {
        
        $sql='SELECT di.id as id, di.nombre as division, ac.nombre as materia, count(he.catedra) as cantidad
                FROM `horarioexamen` he
                LEFT JOIN catedra c ON he.catedra = c.id
                LEFT JOIN detallecatedra dc ON dc.catedra = c.id
                LEFT JOIN agente doc ON dc.agente = doc.id
                LEFT JOIN division di ON c.division = di.id
                LEFT JOIN actividad ac ON c.actividad = ac.id
                LEFT JOIN anioxtrimestral axt ON he.anioxtrimestral = axt.id
                WHERE dc.revista = 6 and he.anioxtrimestral = '.$id.' and axt.activo = 1 and dc.activo = 1 and dc.aniolectivo = axt.aniolectivo
                group by di.nombre, ac.nombre
                HAVING  count(he.catedra)>1';


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

    public function getSuperposicionDocentes($id)
    {
        
        $sql='SELECT doc.id as id, doc.apellido as apellido, doc.nombre as nombre, he.fecha as fecha, he.hora as hora, di.turno as turno, count(concat(doc.id, doc.apellido, doc.nombre, he.fecha, he.hora, di.turno)) as cantidad
            FROM horarioexamen he
            LEFT JOIN catedra c ON he.catedra = c.id
            LEFT JOIN detallecatedra dc ON dc.catedra = c.id
            LEFT JOIN agente doc ON dc.agente = doc.id
            LEFT JOIN division di ON c.division = di.id
            LEFT JOIN actividad ac ON c.actividad = ac.id
            LEFT JOIN anioxtrimestral axt ON he.anioxtrimestral = axt.id
            WHERE dc.revista = 6 and he.anioxtrimestral = '.$id.' and axt.activo = 1 and dc.activo = 1 and dc.aniolectivo = axt.aniolectivo
            group by  doc.id, doc.apellido, doc.nombre, he.fecha, he.hora, di.turno
            having count(concat(doc.id, doc.apellido, doc.nombre, he.fecha, he.hora, di.turno))>1
            order by he.fecha, he.hora, doc.apellido';


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

    public function getMateriasNocargadas($id)
    {

        $al = Anioxtrimestral::findOne($id);
        
        $sql='SELECT di2.id, di2.nombre as division, count(dc2.id not in(
                SELECT dc.id
                FROM `horarioexamen` he
                LEFT JOIN catedra c ON he.catedra = c.id
                LEFT JOIN detallecatedra dc ON dc.catedra = c.id
                LEFT JOIN agente doc ON dc.agente = doc.id
                LEFT JOIN division di ON c.division = di.id
                LEFT JOIN actividad ac ON c.actividad = ac.id
                LEFT JOIN anioxtrimestral axt ON he.anioxtrimestral = axt.id
                WHERE dc.revista = 6 and he.anioxtrimestral = '.$id.' and axt.activo = 1 and dc.activo = 1 and dc.aniolectivo = axt.aniolectivo)) as cantidad
                FROM detallecatedra dc2
                LEFT JOIN catedra c2 ON dc2.catedra = c2.id
                LEFT JOIN agente doc2 ON dc2.agente = doc2.id
                LEFT JOIN division di2 ON c2.division = di2.id
                LEFT JOIN actividad ac2 ON c2.actividad = ac2.id
                WHERE ac2.id not in (7,20,32,44, 195) and dc2.revista = 6 and dc2.aniolectivo =  '.$al->aniolectivo.' and (di2.turno = 1  or di2.turno = 2) and dc2.id not in (
                SELECT dc.id
                FROM `horarioexamen` he
                LEFT JOIN catedra c ON he.catedra = c.id
                LEFT JOIN detallecatedra dc ON dc.catedra = c.id
                LEFT JOIN agente doc ON dc.agente = doc.id
                LEFT JOIN division di ON c.division = di.id
                LEFT JOIN actividad ac ON c.actividad = ac.id
                LEFT JOIN anioxtrimestral axt ON he.anioxtrimestral = axt.id
                WHERE dc.revista = 6 and he.anioxtrimestral = '.$id.' and axt.activo = 1)
                group by di2.id, di2.nombre
                order by di2.id, ac2.nombre';


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

    public function porfecha($id)
    {
        $query = Horarioexamen::find()
            ->joinWith(['catedra0', 'catedra0.division0'])
            ->where(['anioxtrimestral' => $id])
            ->orderBy('horarioexamen.fecha, division.id, horarioexamen.hora');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
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
            'catedra' => $this->catedra,
            'hora' => $this->hora,
            'tipo' => $this->tipo,
            'anioxtrimestral' => $this->anioxtrimestral,
            'fecha' => $this->fecha,
            'cambiada' => $this->cambiada,
        ]);

        return $dataProvider;
    }
}
