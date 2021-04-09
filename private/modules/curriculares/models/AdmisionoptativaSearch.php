<?php

namespace app\modules\curriculares\models;

use Yii;
use app\modules\curriculares\models\Admisionoptativa;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * AdmisionoptativaSearch represents the model behind the search form of `app\modules\optativas\models\Admisionoptativa`.
 */
class AdmisionoptativaSearch extends Admisionoptativa
{

    public $apellidos;
    public $documento;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'alumno', 'curso', 'aniolectivo'], 'integer'],
            [['apellidos', 'documento'], 'string'],
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
        $query = Admisionoptativa::find()
        ->joinWith(['alumno0']);

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
            'curso' => $this->curso,
            'aniolectivo' => $this->aniolectivo,
        ]);
        $query->andFilterWhere(['like', 'alumno.apellido', $this->apellidos]);
        $query->andFilterWhere(['like', 'alumno.documento', $this->documento]);

        return $dataProvider;
    }

    public function porAlumno($id)
    {
        $al = Aniolectivo::find()->where(['activo' => 1])->one();
        $sql = "SELECT alumno, curso, count(id) as cantidad FROM admisionoptativa  WHERE alumno = ".$id." and aniolectivo = ".$al->id."  group by alumno, curso";

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
        /*$query = Admisionoptativa::find()
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
        
        $query = 'SELECT al.documento as documento, al.apellido as apellido, al.nombre as nombre, admisionoptativa.curso as curso FROM admisionoptativa LEFT JOIN alumno al ON admisionoptativa.alumno = al.id WHERE (admisionoptativa.aniolectivo='.$al.') AND (al.id NOT IN (SELECT matricula.alumno FROM matricula LEFT JOIN comision ON matricula.comision = comision.id LEFT JOIN espaciocurricular ON comision.espaciocurricular = espaciocurricular.id WHERE (espaciocurricular.aniolectivo='.$al.') AND (espaciocurricular.curso=admisionoptativa.curso))) ORDER BY admisionoptativa.curso, al.apellido, al.nombre';
        
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
