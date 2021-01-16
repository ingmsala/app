<?php

namespace app\modules\curriculares\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\modules\curriculares\models\Matricula;

/**
 * MatriculaSearch represents the model behind the search form of app\modules\espaciocurriculars\models\Matricula.
 */
class MatriculaSearch extends Matricula
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'alumno', 'comision', 'estadomatricula'], 'integer'],
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
    public function search($params, $tipoespacio)
    {
        $query = Matricula::find()
                ->joinWith(['alumno0', 'comision0', 'comision0.espaciocurricular0', 'comision0.espaciocurricular0.actividad0'])
                ->where(true)
                ->andWhere(

                    (isset($params['Matricula']['aniolectivo']) && $params['Matricula']['aniolectivo'] != '') ? ['espaciocurricular.aniolectivo' => $params['Matricula']['aniolectivo']] : ['espaciocurricular.aniolectivo' => 0])
                ->andWhere(

                    (isset($params['Matricula']['comision']) && $params['Matricula']['comision'] != '') ? ['comision' => $params['Matricula']['comision']] : true)
                ->andWhere(['tipoespacio' => $tipoespacio])
                ->orderBy('actividad.nombre, comision.nombre, alumno.apellido, alumno.nombre');

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha' => $this->fecha,
            'alumno' => $this->alumno,
            'comision' => $this->comision,
            'estadomatricula' => $this->estadomatricula,
        ]);

        return $dataProvider;
    }

    public function alumnosxcomision($comsion)
    {
        $query = Matricula::find()
                ->joinWith(['alumno0', 'comision0', 'comision0.espaciocurricular0', 'comision0.espaciocurricular0.actividad0', 'alumno0.tutors'])
                ->where(['comision.id' => $comsion])
                ->orderBy('actividad.nombre, comision.nombre, alumno.apellido, alumno.nombre');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($comsion);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha' => $this->fecha,
            'alumno' => $this->alumno,
            'comision' => $this->comision,
            'estadomatricula' => $this->estadomatricula,
        ]);

        return $dataProvider;
    }

    public function alumnosxcomisionSinActa($comsion, $ids)
    {
        //$subcons = 
        $query = Matricula::find()
                ->joinWith(['alumno0', 'comision0', 'detalleactas'])
                ->where(['comision.id' => $comsion])
                ->andWhere(['not in', 'matricula.id', $ids])
                ->orderBy('alumno.apellido, alumno.nombre');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($comsion);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha' => $this->fecha,
            'alumno' => $this->alumno,
            'comision' => $this->comision,
            'estadomatricula' => $this->estadomatricula,
        ]);

        return $dataProvider;
    }

    public function alumnosxcomisionmails($comsion)
    {
         $sql="SELECT DISTINCT alumno.apellido, alumno.nombre, tutor.mail FROM matricula LEFT JOIN alumno ON matricula.alumno = alumno.id LEFT JOIN comision ON matricula.comision = comision.id LEFT JOIN espaciocurricular ON comision.espaciocurricular = espaciocurricular.id LEFT JOIN actividad ON espaciocurricular.actividad = actividad.id LEFT JOIN tutor ON alumno.id = tutor.alumno WHERE comision.id=".$comsion." ORDER BY actividad.nombre, comision.nombre, alumno.apellido, alumno.nombre";
        /*$query = Matricula::find()
                ->select(['alumno.apellido', 'alumno.nombre', 'contactoalumno.mail'])->distinct()
                ->joinWith(['alumno0', 'comision0', 'comision0.espaciocurricular0', 'comision0.espaciocurricular0.actividad0', 'alumno0.contactoalumnos'])
                ->where(['comision.id' => $comsion])
                ->orderBy('actividad.nombre, comision.nombre, alumno.apellido, alumno.nombre');*/

        // add conditions that should always apply here

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
        ]);

        $this->load($comsion);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        

        return $dataProvider;
    }

    public function matriculasxalumno($documento)
    {
        $query = Matricula::find()
            ->joinWith(['comision0', 'estadomatricula0', 'comision0.espaciocurricular0', 'comision0.espaciocurricular0.aniolectivo0', 'alumno0'])
            ->where(['alumno.documento' => $documento])
            ->andWhere(['matricula.estadomatricula' => 1])
            ->orderBy('aniolectivo.nombre DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($documento);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        


        return $dataProvider;
    }

    public function inscriptosPorAnioLectivo($al, $tipoespacio)
    {
        $sql ='   SELECT
        actividad.nombre AS actividad,
        comision.nombre AS comision,
        comision.cupo AS cupo,
        espaciocurricular.curso as curso,
        COUNT(matricula.id) AS cantidad
    FROM
        matricula
    LEFT JOIN comision ON matricula.comision = comision.id
    LEFT JOIN espaciocurricular ON comision.espaciocurricular = espaciocurricular.id
    LEFT JOIN actividad ON espaciocurricular.actividad = actividad.id
    WHERE
        (
            espaciocurricular.aniolectivo = '.$al.'
        ) AND(
            espaciocurricular.tipoespacio = '.$tipoespacio.'
        )
    GROUP BY
        actividad.nombre,
        comision.nombre,
        espaciocurricular.curso,
        comision.cupo
    ORDER BY 
        espaciocurricular.curso, actividad.nombre, comision.nombre';

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
