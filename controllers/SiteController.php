<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ReportForm;
use yii\helpers\FileHelper;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'reports', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'reports', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionReports()
    {
        $model = new ReportForm();

        $listYears = [
            date('Y', strtotime('-1 year')) => date('Y', strtotime('-1 year')),
            date('Y', strtotime('-2 year')) => date('Y', strtotime('-2 year')),
            date('Y', strtotime('-3 year')) => date('Y', strtotime('-3 year')),
        ];
        
        if ($model->load(Yii::$app->request->post())) {
            $webservice = Yii::$app->webservice->getReports('informe-rendimento', Yii::$app->user->identity->CD_COLABORADOR, $model->year);
			#pr($webservice);
            if (isset($webservice->erroExecucao) && (strpos($webservice->erroExecucao, 'Não houve informações a listar') !== false)) {
                //Yii::$app->session->setFlash('error', 'Não foi encontrar o informe de rendimento de '. $model->year . '.');
                return $this->render('reports', [
                    'model' => $model,
                    'listYears' => $listYears,
                    'msg' => 'Não foi possível encontrar o informe de rendimento de '. $model->year . '.'
                ]);
            }

            if (empty($webservice->erroExecucao)) { 
                
                $dir = Yii::getAlias('@webroot');
                $path = '/'.'files/'.Yii::$app->user->identity->CD_COLABORADOR.'/';

                if (is_dir($dir.$path)) {
                    FileHelper::removeDirectory($dir.$path);
                    $path = $path.$this->generateHash();
                    FileHelper::createDirectory($dir.$path);
                } else {
                    $path = $path.$this->generateHash();
                    FileHelper::createDirectory($dir.$path);
                }
				#pr($webservice);
                $file = base64_decode($webservice->prRetorno, true); 

                $fileComplete = $path.'/informe_rendimento_'.$model->year.'.pdf';

                file_put_contents($dir.$fileComplete, $file);

                $url = Yii::getAlias('@web').$fileComplete;
                
                /*return Yii::$app->response->sendContentAsFile(
                    base64_decode($webservice->prRetorno), 
                    'InformeRendimento.pdf', 
                    ['mimeType' => 'application/pdf']
                );*/

            } else {
                return $this->render('reports', [
                    'model' => $model,
                    'listYears' => $listYears,
                    'msg' => 'Não foi possível encontrar o informe de rendimento de '. $model->year . '.'
                ]);
            }
        }

        return $this->render('reports', [
            'model' => $model,
            'listYears' => $listYears,
            'file' => $url ?? ''            
        ]);
    }

    public function actionHolerite() {
        $model = new ReportForm();

        if ($model->load(Yii::$app->request->post())) {
            $webservice = Yii::$app->webservice->getReports('holerite', Yii::$app->user->identity->CD_COLABORADOR, $model->validity, $model->type);
			#pr($webservice);
            if (isset($webservice->erroExecucao) && (strpos($webservice->erroExecucao, 'Não houve informações a listar') !== false)) {
                Yii::$app->session->setFlash('error', 'Não foi possível encontrar o holerite da vigência '. $model->validity . '.');

                $listTypes = [
                    11 => 'Cálculo Mensal',
                    14 => 'Pagamento de Dissídio',
                    31 => 'Adiantamento 13º Salário',
                    32 => '13º Salário Integral',
                ];
				
                return $this->render('holerite', [
                    'model' => $model,
                    'msg' => 'Não foi possível encontrar o holerite da vigência '. $model->validity . '.',
                    'listTypes' => $listTypes
                ]);
            }

            if (empty($webservice->erroExecucao)) {
                
                $dir = Yii::getAlias('@webroot');
                $path = '/'.'files/'.Yii::$app->user->identity->CD_COLABORADOR.'/';

                if (is_dir($dir.$path)) {
                    FileHelper::removeDirectory($dir.$path);
                    $path = $path.$this->generateHash();
                    FileHelper::createDirectory($dir.$path);
                } else {
                    $path = $path.$this->generateHash();
                    FileHelper::createDirectory($dir.$path);
                }
                $file = base64_decode($webservice->prRetorno, true); 
                
                $date = explode('/', $model->validity);

                $fileComplete = $path.'/holerite_'.$date[0].'_'.$date[1].'.pdf';

                file_put_contents($dir.$fileComplete, $file);

                $url = Yii::getAlias('@web').$fileComplete;

                /*return Yii::$app->response->sendContentAsFile(
                    base64_decode($webservice->prRetorno), 
                    'Holerite.pdf', 
                    ['mimeType' => 'application/pdf']
                );*/

                /*return $this->render('holerite', [
                    'model' => $model,
                    'file' => $fileComplete
                ]);*/

            } else {
                $listTypes = [
                    11 => 'Cálculo Mensal',
                    14 => 'Pagamento de Dissídio',
                    31 => 'Adiantamento 13º Salário',
                    32 => '13º Salário Integral',
                ];

                Yii::$app->session->setFlash('error', 'Não foi possível encontrar o holerite da vigência '. $model->validity . '.');
                return $this->render('holerite', [
                    'model' => $model,
                    'msg' => 'Não foi possível encontrar o holerite da vigência '. $model->validity . '.',
                    'listTypes' => $listTypes
                ]);
            }
        } else {
            $model->validity = date('m') . '/' . date('Y');
        }

        $listTypes = [
            11 => 'Cálculo Mensal',
            14 => 'Pagamento de Dissídio',
            31 => 'Adiantamento 13º Salário',
            32 => '13º Salário Integral',
        ];

        return $this->render('holerite', [
            'model' => $model,
            'file' => $url ?? '',
            'listTypes' => $listTypes
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(['/informe-rendimento']);
    }

    public function generateHash($l = 13)
    {
        $number = '';
        for ($x = 0; $x < max($l / 6, 1); $x++) {
            $number .= base_convert(mt_rand(), 10, 32);
        }
        return mb_strtoupper(substr($number, 0, $l));
    }
}
