<?php

namespace app\modules\curriculares\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\curriculares\models\Admisionsociocom;
use yii\data\SqlDataProvider;

/**
 * AdmisionsociocomSearch represents the model behind the search form of `app\modules\curriculares\models\Admisionsociocom`.
 */
class AdmisionsociocomSearch extends Admisionsociocom
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'alumno', 'curso', 'aniolectivo', 'turno'], 'integer'],
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
        $query = Admisionsociocom::find();

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
            'alumno' => $this->alumno,
            'curso' => $this->curso,
            'aniolectivo' => $this->aniolectivo,
            'turno' => $this->turno,
        ]);

        return $dataProvider;
    }

    public function porAlumno($id)
    {
        $sql = "SELECT alumno, curso, count(id) as cantidad FROM admisionsociocom  WHERE alumno = ".$id." and aniolectivo = 2  group by alumno, curso";

        // add conditions that should always apply here

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
        ]);

        $this->load($id);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        
        return $dataProvider;
    }

    public function alumnosPendientes($al, $tipoespacio)
    {
        /*$query = Admisionsociocom::find()
                        ->joinWith('alumno0 al')
                        ->where(['admisionoptativa.aniolectivo' => $al])
                        ->andWhere(['not in', 'al.id', 
                            (new Query())->select('matricula.alumno')->from('matricula')
                            ->join('LEFT JOIN', 'comision', 'matricula.comision = comision.id')
                            ->join('LEFT JOIN', 'espaciocurricular', 'comision.espaciocurricular = espaciocurricular.id')
                            ->where(['espaciocurricular.aniolectivo' => $al])
                            ->andWhere(['espacocurricular.tipoespacio' => $tipoespacio])
                            ->andWhere(['espaciocurricular.curso' => 'admisionoptativa.curso'])
                            ])
                        ->orderBy('al.apellido, al.nombre', 'admisionoptativa.curso');*/
        
        $query = 'SELECT al.dni as dni, al.apellido as apellido, al.nombre as nombre, admisionsociocom.curso as curso FROM admisionsociocom LEFT JOIN alumno al ON admisionsociocom.alumno = al.id WHERE (admisionsociocom.aniolectivo=2) AND (al.id NOT IN (SELECT matricula.alumno FROM matricula LEFT JOIN comision ON matricula.comision = comision.id LEFT JOIN espaciocurricular ON comision.espaciocurricular = espaciocurricular.id WHERE (espaciocurricular.aniolectivo=2) AND (espaciocurricular.curso=admisionsociocom.curso))) ORDER BY al.apellido, al.nombre';
        
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
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
