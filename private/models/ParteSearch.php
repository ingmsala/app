<?php

namespace app\models;

use app\config\Globales;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Parte;
use app\modules\curriculares\models\Aniolectivo;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * ParteSearch represents the model behind the search form of `app\models\Parte`.
 */
class ParteSearch extends Parte
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipoparte'], 'integer'],
            [['fecha', 'preceptoria'], 'safe'],
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
        $us = Yii::$app->user->identity->username;
        if ( !in_array ($us, ["msala", "secretaria",'consulta','regenciatt','regenciatm'])) {
        $query = Parte::find()->joinWith('preceptoria0')
               ->where(['preceptoria.nombre' => $us])
               ->orderBy('fecha desc');
        }else{
            if ($us == 'regenciatt') {

            }elseif ($us == 'regenciatt') {

            }else{
                $query = Parte::find()->joinWith('preceptoria0')
                ->orderBy('fecha desc');
            }
            
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

        

        return $dataProvider;
    }

     public function search($params)
    {
        
        $sql='
        select p.id, p.fecha as fecha, pr.nombre as preceptoria, tp.nombre as tipoparte
        from parte p 
        left join preceptoria pr on p.preceptoria = pr.id 
        left join tipoparte tp on p.tipoparte = tp.id
        where true';

        if (isset($params['Parte']['fecha']) && $params['Parte']['fecha'] != ''){
            $sql .= ' and year(p.fecha) = '.$params["Parte"]["fecha"];
        }else{
            $sql .= ' and year(p.fecha) = '.date('Y');
        }
        if (isset($params['Parte']['mes']) && $params['Parte']['mes'] != ''){
            $sql .= ' and month(p.fecha) = '.$params["Parte"]["mes"];
        }
        if ( in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTORIA])) {

            $role = Rolexuser::find()
                ->where(['user' => Yii::$app->user->identity->id])
                ->andWhere(['role' => Globales::US_PRECEPTORIA])
                ->one();


            $sql .= ' and pr.nombre="'.$role->subrole.'"';
            $sql .= ' and year(p.fecha)="'.date('Y').'"';
        }

        if ( in_array (Yii::$app->user->identity->role, [Globales::US_PRECEPTOR])) {

            $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
            $nom = Nombramiento::find()
                        ->where(['agente' => $doc->id])
                        ->andWhere(['<=', 'division', 53])
                        //->andWhere(['is not', 'division', 53])
                        ->all();
            $array = [];

            foreach ($nom as $n) {
                $array [] = $n->division0->preceptoria0->nombre;
            }

            
            $sql .= " and pr.nombre IN('".implode("','",$array)."')";
            $sql .= ' and year(p.fecha)="'.date('Y').'"';
        }

        if (isset($params['Parte']['preceptoria']) && $params['Parte']['preceptoria'] != ''){
            $sql .= ' and p.preceptoria = '.$params["Parte"]["preceptoria"];
        }
        if ( in_array (Yii::$app->user->identity->role, [4])) {
            
            if (Yii::$app->user->identity->username == 'regenciatm'){
                $sql .= ' and pr.turno=1';
            }elseif(Yii::$app->user->identity->username == 'regenciatt'){
                $sql .= ' and pr.turno=2';
            }else{
                $sql .= ' and (pr.turno=1 or pr.turno=2)';//regencia unificada
            }
            
        }
        if ( in_array (Yii::$app->user->identity->role, [12])) {
            $sql .= ' and pr.turno=4';
        }
       
        $sql.= ' order by p.fecha desc';


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
}
