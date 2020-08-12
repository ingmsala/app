<?php

namespace app\modules\libroclase\controllers;

use app\config\Globales;
use app\models\Detallecatedra;
use app\models\Division;
use app\models\Docente;
use app\models\Nombramiento;
use app\models\Preceptoria;
use Yii;
use app\modules\libroclase\models\Clasediaria;
use app\modules\libroclase\models\ClasediariaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClasediariaController implements the CRUD actions for Clasediaria model.
 */
class ClasediariaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Clasediaria models.
     * @return mixed
     */
    public function actionDivision($d)
    {
        $this->layout = '@app/views/layouts/mainpersonal';
        $searchModel = new ClasediariaSearch();
        $division = Division::findOne($d);
        $dataProvider = $searchModel->pordivision($d);
        



        return $this->render('division', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'division' => $division,
        ]);
    }

    public function actionIndex()
    {
        $this->layout = '@app/views/layouts/mainpersonal';
        if(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
            $pre = Preceptoria::find()->where(['nombre' => Yii::$app->user->identity->username])->one();
            $divisiones = Division::find()
                        ->where(['preceptoria' => $pre->id])
                        ->orderBy('id')
                        ->all();
        }elseif(Yii::$app->user->identity->role == Globales::US_DOCENTE){
            //$this->layout = 'mainpersonal';
            $doc = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
            $nom = Nombramiento::find()
                        ->where(['docente' => $doc->id])
                        ->andWhere(['<=', 'division', 53])
                        //->andWhere(['is not', 'division', 53])
                        ->all();
            $array = [];
            foreach ($nom as $n) {
                $array [] = $n->division;
            }

            $dcs = Detallecatedra::find()
                ->joinWith(['catedra0', 'catedra0.division0'])
                ->where(['detallecatedra.docente' => $doc->id])
                ->andWhere(['detallecatedra.revista' => 6])
                ->all();
            
            foreach ($dcs as $dc) {
                $array [] = $dc->catedra0->division;
            }

            $pre = Preceptoria::find()->where(['nombre' => Yii::$app->user->identity->username])->one();
            $divisiones = Division::find()
                        ->where(['in', 'id', $array])
                        ->orderBy('id')
                        ->all();
        
        }else{
            $divisiones = Division::find()
                                    ->where(['in', 'preceptoria', [1,2,3,4,5,6]])
                                    ->orderBy('id')
                                    ->all();
        }
        
        $echodiv = '';
        foreach ($divisiones as $division) {
        		$echodiv .= '<div class="pull-left" style="height: 16vh; width: 16vh; vertical-align: middle;">';
        		$echodiv .= '<center><div>';
                $echodiv .= '<a class="menuHorarios" href="index.php?r=libroclase/clasediaria/division&d='.$division->id.'" role="button" style="font-size:5vh; width:15vh; height: 15vh;">'.$division->nombre.'</a>';
                $echodiv .= '</div></center>';
                $echodiv .= '</div>';
        }
        return $this->render('menuxdivision', [
        	'echodiv' => $echodiv,
        ]);
    }

    /**
     * Displays a single Clasediaria model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Clasediaria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = '@app/views/layouts/mainpersonal';
        $model = new Clasediaria();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Clasediaria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Clasediaria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Clasediaria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clasediaria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clasediaria::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
